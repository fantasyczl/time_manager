@extends ('layouts.main')

@section ('js')
    <script src="/bower_components/jquery-mask-plugin/src/jquery.mask.js"></script>
    <script src="/js/task.js?v=1"></script>
    <script>
        var taskID = {{$id}};
    </script>
@stop

@section ('title')
    Task: {{$id}}
@stop

@section ('content')
    <div class="task" id="task_dev">
    </div>
@stop
