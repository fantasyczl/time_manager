<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Carbon\Carbon;
use App\Models\Task;
use App\Lib\Utils\TimeUtils;


class DateController extends Controller {

    public function index() {
        $user = Auth::user();
        
        $date = new Carbon();
        $date->tz = TimeUtils::TZ_LOCAL;

        $url = '/date/' . $date->year . '/' . sprintf('%02d', $date->month) . '/' . sprintf('%02d', $date->day);
        return redirect($url);
    }

    public function getYear() {
    }

    public function getMonth() {
    }

    public function getDay($y, $m, $d) {
        $user = Auth::user();
        $params = array();

        $dateStr = sprintf('%s-%s-%s', $y, $m, $d);
        $params['date'] = TimeUtils::GetLocalDate($dateStr);
        $params['beforeDay'] = date('Y/m/d', strtotime("-1 day", strtotime($params['date'])));
        $params['afterDay'] = date('Y/m/d', strtotime('+1 day', strtotime($params['date'])));

        $duration = TimeUtils::GetDurationDay($dateStr);
        $tasks = $user->tasks()
            ->whereBetween('start_time', $duration)
            ->get();
        $params['tasks'] = $tasks;

        $projects = $user->projects->all();
        usort($projects, function($a, $b) use ($dateStr) {
            $diff = $a->spendTimeInDay($dateStr) - $b->spendTimeInDay($dateStr);
            return -$diff;
        });

        $projects = array_filter($projects, function($project) use ($dateStr) {
            return $project->spendTimeInDay($dateStr) > 0;
        });

        $params['projects'] = $projects;

        return view('date.day', $params);
    }
}
