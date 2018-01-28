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
    <script src="/js/dashboard.js?v=1"></script>
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

                    <div class="col-xs-5 col-md-5">
                        <input class="form-control" type="text" name="task_date" value="{{ $taskDate }}">
                    </div>

                    <div class="col-xs-5 col-md-5">
                        <input id="task_time" type="time" name="task_time" class="form-control" value="{{ $taskTime }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-7">
                        {!! Form::select('task_name', $selectProjects, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-xs-5">
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
                <div class="col-xs-1"><label for="">ID</label></div>
                <div class="col-xs-4"><label for="">Start Time</label></div>
                <div class="col-xs-3"><label for="">Project Name</label></div>
                <div class="col-xs-4"><label for="">Duration</label></div>
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
                            Going On {{ \App\Lib\Utils\TimeUtils::diffForHuman($task->start_time) }}
                        @else
                            Continue {{ \App\Lib\Utils\TimeUtils::durationForHuman($task->duration)}}
                        @endif
                    </div>
                </div>
            @endforeach

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
                                    <div class="col-xs-5">
                                        <label for="">
                                            <a href="javascript:void(0);" onclick="showProjectTasksInDay({{ $project->id }});">
                                                共{{ $project->spendTimeInDayForHuman() }}
                                            </a>
                                        </label>
                                    </div>
                                </div>
                                <div id="{{ $project->id }}_tasks" class="row project-task-in-day" style="display: none;"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
