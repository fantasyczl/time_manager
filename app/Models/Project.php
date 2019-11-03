<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
use App\Lib\Utils\TimeUtils;

class Project extends Model
{
    const STATUS_USEING = 0;  // 正常使用
    const STATUS_HIDE = 1; // 不常使用

    const STATUSES = [
        self::STATUS_USEING => '正常使用',
        self::STATUS_HIDE   => '不常使用',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function tasks() {
        return $this->hasMany('App\Models\Task');
    }

    public function spendTimeInDay($day = null) {
        $tz = 'Asia/Shanghai';

        if (empty($day))
            $start = Carbon::now($tz);
        else 
            $start = new Carbon($day, $tz);

        $start->hour(0)->minute(0)->second(0);
        $start->tz = 'UTC';

        $end = clone $start;
        $end->addDay();

        $start_time = $start->toDateTimeString();
        $end_time = $end->toDateTimeString();
        
        $tasks = $this->tasks()
            ->whereBetween('start_time', [$start_time, $end_time])
            ->get();

        $total = 0;
        foreach ($tasks as $task) {
            if ($task->duration == 0)
                $task->duration = TimeUtils::diff($task->start_time);
            
            $total += $task->duration;
        }

        return $total;
    }


    public function spendTimeInDayForHuman($day = null) {
        $total = $this->spendTimeInDay($day);

        if ($total == 0)
            return '0分';

        return \App\Lib\Utils\TimeUtils::durationForHuman($total);
    }


    public function spendTime() {
        $total = 0;

        foreach ($this->tasks as $task) {
            if ($task->duration == 0) {
                $task->duration = TimeUtils::diff($task->start_time);
            }

            $total += $task->duration;
        }
        
        return $total;
    }

    public function spendTimeForHuman() {
        $total = $this->spendTime();
        return TimeUtils::durationForHuman($total);
    }

    public function statusDisplay()
    {
        return self::STATUSES[$this->status] ?? '未知';
    }
}
