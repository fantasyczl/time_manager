@extends ('layouts.main')

@section ('title')
    Task: {{ $task->project->name }}
@stop

@section ('content')
    <div class="task">

        <div class="title">
            <h2>Task: {{ $task->project->name }}</h2>
            <a href="/tasks/{{ $task->id }}/edit">Edit</a>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <label for="">Project Name</label>
            </div>
            <div class="col-xs-9">{{ $task->project->name }}</div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <label for="">Start At</label>
            </div>
            <div class="col-xs-9">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <label for="">Continue</label>
            </div>
            <div class="col-xs-9">
                @if ($task->duration)
                    {{ \App\Lib\Utils\TimeUtils::durationForHuman($task->duration) }}
                @else
                    {{ \App\Lib\Utils\TimeUtils::diffForHuman($task->start_time) }}
                @endif
            </div>
        </div>
    </div>
@stop
