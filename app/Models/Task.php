<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user() {
        return $this->belongsTo('App\Models\User');
    }


    public function project() {
        return $this->belongsTo('App\Models\Project');
    }


    public function calculateDuration($endTime = null) {
        if ($this->duration != 0)
            throw new Exception('duration计算错误');

        if ($endTime == null)
            $endTime = time();
        else
            $endTime = strtotime($endTime);
        
        $diff = $endTime - strtotime($this->start_time);

        $this->duration = $diff;
        $this->save();
    }

}
