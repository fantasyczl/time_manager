@extends ('layouts.main')

@section ('css')
    <style>
        .row {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
@stop


@section ('js')
    <script>
        function addTask() {
            var id = $('select[name=task_name]').val();
            if (!id) {
                alert('请选择项目');
                return false;
            }

            $.ajax({
                url: '/tasks/ajax/addTask',
                type: 'POST',
                data: {'project_id': id},
                success: function(data) {
                    if (data['err_code'] !== 0) {
                        alert(data['message']);
                        return false;
                    }

                    location.reload();
                },
                error: function(data) {
                    alert(JSON.stringify(data));
                }
            });
        }
    </script>
@stop

@section ('content')
        <h2> Dashboard </h2>

        <div class="tasks">
            <h4>时间线</h4>

            <div class="add-task">
                <div class="row">
                    <div class="col-xs-3">
                        {!! Form::select('task_name', $selectProjects, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-xs-2">
                        <a class="btn btn-success" href="javascript:void(0);" onclick="addTask();">添加</a>
                    </div>
                    <div class="col-xs-3"><a href="/projects/create">添加项目</a></div>
                </div>
            </div>

            @foreach ($tasks as $task)
                <div class="row">
                    <div class="col-xs-2">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
                    <div class="col-xs-4">
                        {{ $task->project->name }}
                    </div>
                    <div class="col-xs-3">
                        {{ \App\Lib\Utils\TimeUtils::diffForHuman($task->duration)}}
                    </div>
                </div>
            @endforeach

        </div>

        <hr>

        <div class="projects">
            <h4>项目</h4>
            @if (count($projects) > 0)
                @foreach ($projects as $project)
                    {{ $project->name }}
                    <br>
                @endforeach
            @else
                你还没有任何项目，<a href="/projects/create">请创建</a>
            @endif
        </div>
@stop
