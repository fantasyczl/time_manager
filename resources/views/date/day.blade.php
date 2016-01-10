@extends ('layouts.main')

@section ('title')
    {{ $date }}
@stop

@section ('css')
    <style>
        #time_label {
            display: none;
        }
    </style>
@stop

@section ('content')

    <div class="col-xs-12 col-md-6">
        <h2>时间线</h2>
        <hr>

        <div class="tasks">
            <hr>

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
        <h2>每天情况统计</h2>
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
                                    <div class="col-xs-5"><label for="">共{{ $project->spendTimeInDayForHuman() }}</label></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
