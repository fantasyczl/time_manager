<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Project extends Model
{

    public function user() {
        return $this->belongsTo('App\Models\User');
    }


    public function tasks() {
        return $this->hasMany('App\Models\Task');
    }


    public function spendTimeInDay($end = null) {
        if (empty($end))
            $end = Carbon::now();

        $start = clone $end;
        $start->subDay();

        $start_time = $start->toDateTimeString();
        $end_time = $end->toDateTimeString();
        
        $tasks = $this->tasks()
            ->whereBetween('start_time', [$start_time, $end_time])
            ->get();

        $total = 0;
        foreach ($tasks as $task)
            $total += $task->duration;

        if ($total == 0)
            return '0分';

        return \App\Lib\Utils\TimeUtils::durationForHuman($total);
    }
}
