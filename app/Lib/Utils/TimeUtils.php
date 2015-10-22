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
}

