@extends ('layouts.main')

@section ('title')
    Task: {{ $task->project->name }}
@stop

@section ('content')
    <div class="task">

        <div class="title">
            <h2>Task: {{ $task->project->name }}</h2>
            <a href="/tasks/{{ $task->id }}/edit">编辑</a>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <label for="">项目名称</label>
            </div>
            <div class="col-xs-9">{{ $task->project->name }}</div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <label for="">开始时间</label>
            </div>
            <div class="col-xs-9">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <label for="">持续时间</label>
            </div>
            <div class="col-xs-9">{{ \App\Lib\Utils\TimeUtils::durationForHuman($task->duration) }}</div>
        </div>
    </div>
@stop
