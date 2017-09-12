<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Project;
use App\Models\Task;
use App\Lib\Utils\TimeUtils;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $tasks = $user->tasks()
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        return view('tasks.show', [
            'task' => $task,
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
        $user = Auth::user();
        $task = Task::find($id);
        $projects = [];

        foreach ($user->projects as $pro) {
            $projects[$pro->id] = $pro->name;
        }

        $isShowDeleteBtn = false;
        $lastTask = Task::orderBy('start_time', 'desc')->first();
        if ($lastTask != null && $lastTask->id == $task->id) {
            $isShowDeleteBtn = true;
        }

        return view('tasks.edit', compact('task', 'projects', 'isShowDeleteBtn'));
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
        $task = Task::find($id);
        $task->project_id = $request->input('project_id');

        if ($request->has('duration')) {
            $task->duration = $request->duration;
        }

        $task->save();

        return redirect('/tasks/' . $id)->with('successMessages', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task == null) {
            abort(404);
        }

        $task->delete();

        $preTask = Task::orderBy('start_time', 'desc')->first();

        if ($preTask && $preTask->duration != 0) {
            $preTask->duration = 0;
            $preTask->save();
        }

        return redirect('/tasks')->with('successes', 'Delete successful!');
    }


    public function ajaxAddTask(Request $request) {
        $user = Auth::user();

        $this->validate($request, [
            'project_id' => 'required|integer',
            'date_time' => 'date|nullable',
        ]);

        if (!$request->has('project_id'))
            return response()->json([
                    'err_code' => 1,
                    'message' => '缺少参数',
                ]);

        $projectId = $request->input('project_id');
        $project = Project::find($projectId);

        if ($project == null)
            return response()->json([
                    'err_code' => 2,
                    'message' => '参数错误',
                ]);

        $dateTime = date('Y-m-d H:i:s');

        if ($request->has('date_time') && !empty($request->date_time)) {
            $dateTime = $request->input('date_time');
            $pattern = '/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}/';

            $match = array();
            $isMatch = preg_match($pattern, $dateTime, $match);

            if ($isMatch && isset($match[0]) && $match[0] == $dateTime) {
                $dateTime .= ':00';
                $dateTime = TimeUtils::GetUTCTime($dateTime);
            } else {
                $dateTime = date('Y-m-d H:i:s');
            }
        }

        if (strtotime($dateTime) > time()) {
            return response()->json([
                'err_code' => 2,
                'message' => '时间错误',
            ]);
        }

        $preTask = $user->tasks()
            ->where('start_time', '<=', $dateTime)
            ->orderBy('start_time', 'desc')
            ->first();

        if ($preTask != null) {
            if ($preTask->project_id == $project->id)
                return response()->json([
                        'err_code' => 3,
                        'message' => '任务重复',
                    ]);

            $preTask->calculateDuration($dateTime);
        }


        $task = new Task();
        $task->project_id = $project->id;
        $task->user_id = $user->id;
        $task->start_time = $dateTime;
        $task->save();

        return response()->json([
            'err_code' => 0,
            'message' => 'success',
        ]);
    }
}
