<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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


    public function ajaxAddTask(Request $request) {
        $user = Auth::user();

        if (!$request->has('project_id'))
            return response()->json(
                [
                    'err_code' => 1,
                    'message' => '缺少参数',
                ]
            );

        $projectId = $request->input('project_id');

        $project = Project::find($projectId);

        if ($project == null)
            return response()->json(
                [
                    'err_code' => 2,
                    'message' => '参数错误',
                ]
            );

        $dateTime = date('Y-m-d H:i:s');

        if ($request->has('date_time')) {
            $dateTime = $request->input('date_time');
            $pattern = '/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}/';

            $match = array();
            $isMatch = preg_match($pattern, $dateTime, $match);

            if ($isMatch && isset($match[0]) && $match[0] == $dateTime) {
                $dateTime .= ':00';
                $dateTime = \App\Lib\Utils\TimeUtils::GetUTCTime($dateTime);
            } else {
                $dateTime = date('Y-m-d H:i:s');
            }
        }
        var_dump($dateTime);
        exit();

        $preTask = $user->tasks()
            ->where('start_time', '<', $dateTime)
            ->orderBy('start_time', 'desc')
            ->first();

        if ($preTask != null) {
            if ($preTask->project_id == $project->id)
                return response()->json(
                    [
                        'err_code' => 3,
                        'message' => '任务重复',
                    ]
                );

            $preTask->calculateDuration();
        }


        $task = new Task();
        $task->project_id = $project->id;
        $task->user_id = $user->id;
        $task->start_time = $dateTime;//date('Y-m-d H:i:s');
        $task->save();

        return response()->json([
            'err_code' => 0,
            'message' => 'success',
        ]);
    }
}
