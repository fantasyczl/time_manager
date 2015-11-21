<?php

namespace App\Lib\Utils;

use Carbon\Carbon;

class TimeUtils {
    const TZ_LOCAL = 'Asia/Shanghai';
    const TZ_UTC = 'UTC';

    public static $weekdays = array(
        '星期日',
        '星期一',
        '星期二',
        '星期三',
        '星期四',
        '星期五',
        '星期六',
    );

    public static function GetDayLocal($timeStr = null) {
        $tz = self::TZ_LOCAL;
        $time = new Carbon($timeStr);
        $time->tz = $tz;
        //$time->hour(0)->minute(0)->second(0);

        return $time->toDateString();
    }
    
    public static function GetLocalTime($timeStr, $tz = null) {
        if (empty($tz))
            $tz = 'Asia/Shanghai';

        $time = new Carbon($timeStr);
        $time->tz = $tz;
        return $time->format('Y-m-d H:i:s');
    }


    public static function GetUTCTime($timeStr, $tz = null) {
        if (empty($tz))
            $tz = 'Asia/Shanghai';

        $time = new Carbon($timeStr, $tz);
        $time->tz = 'UTC';
        return $time->format('Y-m-d H:i:s');
    }


    public static function diff($timeStr) {
        $duration = time() - strtotime($timeStr);
        return $duration;
    }


    public static function diffForHuman($timeStr) {
        $duration = self::diff($timeStr);
        $str = self::durationForHuman($duration);
        
        return $str;
    }


    public static function durationForHuman($seconds) {
        if (empty($seconds))
            return null;

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

        $str = '';
        if ($hours > 0)
            $str .= $hours . '小时';

        if ($mins > 0)
            $str .= $mins . '分';

        if ($sec > 0)
            $str .= $sec .'秒';

        return  $str;
    }


    public static function GetLocalWeekDay($timeStr = null) {
        $tz = self::TZ_LOCAL;
        $time = new Carbon($timeStr);
        $time->tz = $tz;

        $index = $time->dayOfWeek;

        return self::$weekdays[$index];
    }
}
