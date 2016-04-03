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


    public static function GetLocalDate($timeStr = null) {
        $tz = self::TZ_LOCAL;
        $time = new Carbon($timeStr);
        $time->tz = $tz;

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
            return '0分';

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

        if ($mins > 0 || $hours > 0)
            $str .= sprintf("%02d分", $mins);

        if ($sec > 0)
            $str .= sprintf("%02d秒", $sec);

        return  $str;
    }


    public static function GetLocalWeekDay($timeStr = null) {
        $tz = self::TZ_LOCAL;
        $time = new Carbon($timeStr);
        $time->tz = $tz;

        $index = $time->dayOfWeek;

        return self::$weekdays[$index];
    }


    public static function GetDurationDay($timeStr = null, $tz = self::TZ_LOCAL) {
        $begin = new Carbon($timeStr, $tz);

        $end = clone $begin;
        $end->addDay()->subSecond();

        $begin->tz = self::TZ_UTC;
        $end->tz = self::TZ_UTC;

        return [$begin, $end];
    }


    public static function timeRemainingToday($str = null) {
        
    }
}
