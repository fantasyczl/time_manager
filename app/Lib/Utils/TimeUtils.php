<?php

namespace App\Lib\Utils;

use Carbon\Carbon;

class TimeUtils {
    
    public static function GetLocalTime($timeStr, $tz = null) {
        if (empty($tz))
            $tz = 'Asia/Shanghai';

        $time = new Carbon($timeStr);
        $time->tz = $tz;
        return $time->format('Y-m-d H:i:s');
    }


    public static function diffForHuman($seconds) {
        if (empty($seconds))
            return '进行中';

        $hours = $mins = $sec = 0;


        if ($seconds >= 3600) {
            $hours = (int) ($seconds / 3600);
            $seconds = $seconds % 3600;
        }

        if ($seconds >= 60) {
            $mins = (int) ($seconds / 60);
            $seconds = $seconds % 60;
        }

        $sec = $seconds;

        $str = '持续';
        if ($hours > 0)
            $str .= $hours . '小时';

        if ($mins > 0)
            $str .= $mins . '分';

        if ($sec > 0)
            $str .= $sec .'秒';

        return  $str;
    }

}


