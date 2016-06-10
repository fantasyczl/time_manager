<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;

use App\Models\Project;

use App\Lib\Utils\TimeUtils;
use Carbon\Carbon;


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

        $projects = $user->projects()->orderBy('order')->get();

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

        $project = new Project;
        $project->user_id = $user->id;
        $project->name = $request->input('name');

        if ($request->has('description'))
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
        $project = Project::find($id);

        if ($project == null)
            abort(404);

        $spendTime = array();

        $firstTask = $project->tasks()
            ->orderBy('start_time', 'asc')->first();

        $timeArr = array();

        if ($firstTask) {
            $today = new Carbon(TimeUtils::GetLocalDate());
            $firstDay = new Carbon(TimeUtils::GetLocalDate($firstTask->start_time));

            do {
                $dayStr = $firstDay->toDateString();
                $time = $project->spendTimeInDayForHuman($dayStr);
                $timeArr[$dayStr] = $time;
                $firstDay->addDay();
            } while($today->gte($firstDay));
        }

        $timeArr = array_reverse($timeArr);

        return view('projects.show', [
            'project' => $project,
            'timeArr' => $timeArr,
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
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $project->name = $request->input('name');

        if ($request->has('description'))
            $project->description = $request->input('description');
        else
            $project->description = null;

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
}
