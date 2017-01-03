@extends ('layouts.main')

@section ('title')
    Time Line
@stop

@section ('content')
    <div class="tasks">
        @foreach ($tasks as $task)
            <div class="row">
                <div class="col-xs-2">
                    <a href="/tasks/{{ $task->id }}">{{ $task->id }}</a>
                </div>
                <div class="col-xs-3">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
                <div class="col-xs-3">
                    <a href="/projects/{{ $task->project->id }}">
                        {{ $task->project->name }}
                    </a>
                </div>
                <div class="col-xs-4">
                    @if (empty($task->duration))
                        Going On {{ \App\Lib\Utils\TimeUtils::diffForHuman($task->start_time) }}
                    @else
                        Continue {{ \App\Lib\Utils\TimeUtils::durationForHuman($task->duration)}}
                    @endif
                </div>
            </div>
        @endforeach

        {!! $tasks->render() !!}
    </div>
@stop
