@extends ('layouts.main')


@section ('content')
    <div class="tasks"><a href="/tasks/{{ $task->id }}/edit">编辑</a></div>
@stop
