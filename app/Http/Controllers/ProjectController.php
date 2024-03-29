<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Lib\Utils\TimeUtils;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $projects = $user->allProjects()->get();

        if ($request->has('spendTime') && $request->spendTime == 'desc') {
            $projects = $projects->sort(function($a, $b) {
                return $b->spendTime() - $a->spendTime();
            });
        }

        return view('projects.index',[
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user == null)
            abort(404);

        $order = $user->projects()->max('order');

        $project = new Project;
        $project->user_id = $user->id;
        $project->name = $request->input('name');
        $project->status = $request->input('status');
        $project->order = $order + 1;

        if ($request->has('description') && !empty($request->description))
            $project->description = $request->input('description');

        $project->save();

        return redirect('/projects/' . $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('projects.show', [
            'id' => $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);

        if ($project == null)
            abort(404);

        return view('projects.edit', [
            'project' => $project,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if ($project == null)
            abort(404);
       
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:100',
                'status' => 'required|int',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $project->name = $request->input('name');
        $project->status = $request->input('status');

        if ($request->has('description') && !empty($request->description)) {
            $project->description = $request->input('description');
        } else {
            $project->description = null;
        }

        $project->save();

        return redirect('/projects/' . $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxSaveOrders(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['message' => '缺少参数']);
        }
        
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            Project::where('id', $id)->update(['order' => $i]);
        }

        return response()->json(['status' => 0, 'message' => 'success']);
    }

    public function ajaxShowTasksInDay(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:projects,id',
            'date' => 'date|nullable',
        ]);

        $project = Project::find($request->id);

        if ($request->has('date') && !empty($request->date)) {
            $localDate = $request->date;
        } else {
            $localDate = TimeUtils::GetLocalDate(date('Y-m-d'));
        }

        $region = TimeUtils::GetDurationDay($localDate);

        $tasks = $project->tasks()->whereBetween('start_time', $region)->get();

        $data = [];
        foreach ($tasks as $task) {
            $item = [
                'id' => $task->id,
                'start_time' => TimeUtils::GetLocalTime($task->start_time),
                'duration' => TimeUtils::durationForHuman($task->duration),
            ];

            if ($task->duration == 0) {
                $item['duration'] = TimeUtils::durationForHuman(TimeUtils::diff($task->start_time));
            }

            $data[] = $item;
        }

        return response()->json([
            'err_code' => 0, 
            'message' => 'ok',
            'data' => $data]
        );
    }
}
