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

            var date = $('input[name=task_date]').val();
            var time = $('input[name=task_time]').val();
            var dateTime = '';
            if (date && time)
                dateTime = date + ' ' + time;

            $.ajax({
                url: '/tasks/ajax/addTask',
                type: 'POST',
                data: {'project_id': id, 'date_time': dateTime},
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

    <div class="col-xs-12 col-md-6">
        <h2>时间线</h2>
        <hr>

        <div class="tasks">
            <h4>添加任务</h4>

            <div class="add-task">
                <div class="row">
                    <!--
                        <div class="col-xs-1">
                        <label for="">时间</label>
                        </div>
                        <div class="col-xs-2"><input class="form-control" type="date" name="task_date"></div>

                        <div class="col-xs-2">
                        <input type="time" name="task_time" class="form-control">
                        </div>
                    -->

                    <div class="col-xs-5">
                        {!! Form::select('task_name', $selectProjects, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-xs-2">
                        <a class="btn btn-success" href="javascript:void(0);" onclick="addTask();">添加</a>
                    </div>
                </div>
            </div>

            <hr>

            @foreach ($tasks as $task)
                <div class="row">
                    <div class="col-xs-4">{{ \App\Lib\Utils\TimeUtils::GetLocalTime($task->start_time) }}</div>
                    <div class="col-xs-4">
                        {{ $task->project->name }}
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
            <h4>24小时内概况</h4>

            <div class="row">
                <div class="col-xs-12 col-md-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>{{ \App\Lib\Utils\TimeUtils::GetLocalTime(date('Y-m-d H:i:s', time())) }}（24小时内）</h4>
                        </div>

                        <div class="panel-body">
                            @foreach ($projects as $project)
                                <div class="row">
                                    <div class="col-xs-5"><label for="">{{ $project->name }}</label></div>
                                    <div class="col-xs-5"><label for="">共{{ $project->spendTimeInDay() }}</label></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
