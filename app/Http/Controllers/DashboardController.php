<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;


class DashboardController extends Controller
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
            ->take(10)
            ->get();

        $projects = $this->spendTimeInDayProjects($user);

        // project array for select
        $projectArray = array();
        $projectArray[''] = '-';

        foreach ($user->projects as $project) {
            $projectArray[$project->id] = $project->name;
        }

        return view('dashboard.index', [
            'user' => $user,
            'tasks' => $tasks,
            'projects' => $projects,
            'selectProjects' => $projectArray,
        ]);
    }

    private function spendTimeInDayProjects($user)
    {
        $projects = $user->projects->all();

        usort($projects, function($a, $b) {
            $diff = $a->spendTimeInDay() - $b->spendTimeInDay();
            return -$diff;
        });

        foreach ($projects as $k => $project) {
            if ($project->spendTimeInDay() == 0) {
                unset($projects[$k]);
            }
        }

        return $projects;
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
}
