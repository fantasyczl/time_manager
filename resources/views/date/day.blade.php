@extends ('layouts.main')

@section ('title')
    {{ $date }}
@stop

@section ('css')
    <style>
        #time_label {
            display: none;
        }
        .vertical-center {
            min-height: 50px;  /* Fallback for browsers do NOT support vh unit */

            display: flex;
            align-items: center;
        }
        .day {
            font-size: 2em;
            display: relative;
            top: 50%;
            transform: translateY(15%);
        }
    </style>
@stop

@section ('content')
    <div class="row">
        <div class="col-xs-4">
            <a class="vertical-center btn pull-right day left-day" href="/date/{{ $beforeDay }}">Before</a>
        </div>
        <div class="col-xs-4" >
            <h2 style="text-align: center">{{ $date }}</h2>
        </div>
        <div class="vertical-center col-xs-4">
            <a class="btn day right-day" href="/date/{{ $afterDay }}">After</a>
        </div>
    </div>

    <div class="col-xs-12 col-md-6">
        <h4>时间线</h4>
        <hr>

        <div class="tasks">
            <div class="row">
                <div class="col-xs-1"><label for="">ID</label></div>
                <div class="col-xs-4"><label for="">开始时间</label></div>
                <div class="col-xs-3"><label for="">项目名</label></div>
                <div class="col-xs-4"><label for="">持续时间</label></div>
            </div>

            @foreach ($tasks as $task)
                <div class="row">
                    <div class="col-xs-1"><a href="/tasks/{{ $task->id }}">{{ $task->id }}</a></div>
                    <div class="col-xs-4">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
                    <div class="col-xs-3">
                        <a href="/projects/{{ $task->project->id }}">
                            {{ $task->project->name }}
                        </a>
                    </div>
                    <div class="col-xs-4">
                        @if (empty($task->duration))
                            已进行{{ \App\Lib\Utils\TimeUtils::diffForHuman($task->start_time) }}
                        @else
                            持续{{ \App\Lib\Utils\TimeUtils::durationForHuman($task->duration)}}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="col-xs-12 col-md-6">
        <h4>每天情况统计</h4>
        <hr>
        
        <div class="statistics">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>{{ \App\Lib\Utils\TimeUtils::GetLocalDate($date) }} {{ \App\Lib\Utils\TimeUtils::GetLocalWeekDay($date) }}</h4>
                        </div>

                        <div class="panel-body">
                            @foreach ($projects as $project)
                                <div class="row">
                                    <div class="col-xs-5">
                                        <a href="/projects/{{ $project->id }}">
                                            <label for="">{{ $project->name }}</label>
                                        </a>
                                    </div>
                                    <div class="col-xs-5"><label for="">共{{ $project->spendTimeInDayForHuman($date) }}</label></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
