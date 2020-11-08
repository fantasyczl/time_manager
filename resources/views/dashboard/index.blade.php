@extends ('layouts.main')

@section ('title')
    Dashboard
@stop

@section ('css')
    <link rel="stylesheet" href="/css/project.css">
    <style>
        #time_label {
            display: none;
        }
    </style>
@stop


@section ('js')
    <script src="/bower_components/jquery-mask-plugin/src/jquery.mask.js"></script>
    <script src="/js/dashboard.js?v=6"></script>
    <script src="/js/project.js"></script>

    <script>
        $(function() {
            $("input[name=task_date]").datepicker({
                dateFormat: "yy-mm-dd"
            });

        })
    </script>
@stop

@section ('content')

    <div class="col-xs-12 col-md-6">
        <h2>Time Line</h2>
        <hr>

        <div class="tasks">
            <h4>Add Task</h4>

            <div class="add-task">
                <div class="row">
                    <div class="col-xs-12">
                        <a href="javascript:void(0);" onclick="showTimeLabel();">Show Time</a>
                    </div>
                </div>

                <div class="row" id="time_label">
                    <div class="col-xs-2 col-md-2">
                        <label for="">Time</label>
                    </div>

                    <?php
                    $localDate = \App\Lib\Utils\TimeUtils::GetLocalTime(date('Y-m-d H:i:s'));
                    $localTime = strtotime($localDate);
                    $taskDate = date('Y-m-d', $localTime);
                    $taskTime = date('H:i', $localTime);
                    ?>

                    <div class="col-xs-12 col-md-5">
                        <input class="form-control" type="text" name="task_date" value="{{ $taskDate }}">
                    </div>

                    <div class="col-xs-12 col-md-5">
                        <input id="task_time" type="time" name="task_time" class="form-control" value="{{ $taskTime }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-7">
                        {!! Form::select('task_name', $selectProjects, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-xs-12 col-md-5">
                        <a id="add_task_btn"
                           class="btn btn-success"
                           style="width:100%;"
                           href="javascript:void(0);"
                           onclick="addTask();">Add Task</a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-xs-2 col-md-1"><label for="">ID</label></div>
                <div class="col-xs-4 col-md-4"><label for="">Start Time</label></div>
                <div class="col-xs-2 col-md-3"><label for="">Project Name</label></div>
                <div class="col-xs-4 col-md-4"><label for="">Duration</label></div>
            </div>

            <div id="task_list_body">
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <a href="/tasks">More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-6">
        <h2>A Day Of Statistical</h2>
        <hr>
        
        <div class="statistics">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="panel panel-primary">
                        <div id="today_project_title_div" class="panel-heading">
                            <h4 id="today_project_title"></h4>
                        </div>
                        <div id="today_project_list" class="panel-body">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
