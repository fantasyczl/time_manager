@extends ('layouts.main')


@section ('content')
    <div class="tasks">
        @foreach ($tasks as $task)
            <div class="row">
                <div class="col-xs-4">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
                <div class="col-xs-4">
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
@stop
