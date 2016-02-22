@extends ('layouts.main')

@section ('title')
@stop

@section ('content')
    <div><a href="/schedules/create">创建计划</a></div>
    <h2>计划表</h2>

    <div class="schedules">
        @foreach ($schedules as $schedule)
            {{ $schedule->id }}
            {{ $schedule->name }}
        @endforeach
    </div>

@stop
