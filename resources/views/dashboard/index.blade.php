@extends ('layouts.main')

@section ('title')
    Dashboard
@stop

@section ('css')
    <style>
        #time_label {
            display: none;
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

            $('#add_task_btn').addClass('disabled');
            $('#add_task_btn').text('添加中...');

            var date = $('input[name=task_date]').val();
            var time = $('input[name=task_time]').val();

            var dateTime = '';

            var display = $('#time_label').css('display');

            if (date && time && display != 'none')
                dateTime = date + ' ' + time;

            $.ajax({
                url: '/tasks/ajax/addTask',
                type: 'POST',
                data: {'project_id': id, 'date_time': dateTime},
                success: function(data) {
                    if (data['err_code'] !== 0) {
                        alert(data['message']);
                        location.reload();
                        return false;
                    }

                    location.reload();
                },
                error: function(data) {
                    alert(JSON.stringify(data));
                }
            });
        }


        function showTimeLabel() {
            var obj = $('#time_label');
            if (obj.css('display') == 'none') 
                obj.css('display', 'block')
            else
                obj.css('display', 'none')
        }

        $(function() {
            $("input[name=task_date]").datepicker({
                dateFormat: "yy-mm-dd"
            });
        })
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
                    <div class="col-xs-12">
                        <a href="javascript:void(0);" onclick="showTimeLabel();">显示时间</a>
                    </div>
                </div>

                <div class="row" id="time_label">
                    <div class="col-xs-2 col-md-2">
                        <label for="">时间</label>
                    </div>

                    <?php
                    $localDate = \App\Lib\Utils\TimeUtils::GetLocalTime(date('Y-m-d H:i:s'));
                    $localTime = strtotime($localDate);
                    $taskDate = date('Y-m-d', $localTime);
                    $taskTime = date('H:i', $localTime);
                    ?>

                    <div class="col-xs-5 col-md-5">
                        <input class="form-control" type="text" name="task_date" value="{{ $taskDate }}">
                    </div>

                    <div class="col-xs-5 col-md-5">
                        <input type="time" name="task_time" class="form-control" value="{{ $taskTime }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-7">
                        {!! Form::select('task_name', $selectProjects, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-xs-5">
                        <a id="add_task_btn" class="btn btn-success" style="width:100%;" href="javascript:void(0);" onclick="addTask();">添加</a>
                    </div>
                </div>
            </div>

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

            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <a href="/tasks">更多</a>
                    </div>
                </div>
            </div>
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
                            <h4>{{ \App\Lib\Utils\TimeUtils::GetLocalDate() }} {{ \App\Lib\Utils\TimeUtils::GetLocalWeekDay()}}</h4>
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
