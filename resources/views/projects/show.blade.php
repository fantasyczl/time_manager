@extends ('layouts.main')

@section ('title')
    {{ $project->name }}
@stop

@section ('css')
    <style>
    </style>
@stop

@section ('content')
    <div class="title">
        <h2>项目</h2>
        <a href="/projects/{{ $project->id }}/edit">编辑</a>
    </div>

    <div class="project">
        <div class="row">
            <div class="col-xs-3"><label for="">项目名</label></div>
            <div class="col-xs-5">
                <label>{{ $project->name }}</label>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"><label for="">描述</label></div>
            <div class="col-xs-5">
                {{ $project->description }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"><label for="">创建于</label></div>
            <div class="col-xs-5">
                {{ \App\Lib\Utils\TimeUtils::GetLocalTime($project->created_at) }}
                （距今{{ \App\Lib\Utils\TimeUtils::diffForHuman($project->created_at) }}）
            </div>
        </div>
    </div>

    <hr>

    <div class="time-seciton">
        <h4>时间投入</h4>

        <div class="row">
            <div class="col-xs-6 col-md-1"><label for="">共投入时间</label></div>

            <div class="col-xs-6 col-md-2">
                {{ $project->spendTimeForHuman() }}
            </div>

            <div class="col-xs-6 col-md-1">
                跨度{{count($timeArr)}}天 
            </div>

            <div class="col-xs-6 col-md-2">
                <?php
                $durationPerDay = 0;
                if (count($timeArr) > 0) {
                    $durationPerDay = $project->spendTime() / count($timeArr);
                }
                $timeHuman = \App\Lib\Utils\TimeUtils::durationForHuman($durationPerDay);
                ?>
                平均每天{{ $timeHuman }}
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6">

                <table class="table table-striped">
                    <tr>
                        <th>日期</th>
                        <th>投入时间</th>
                    </tr>

                    @foreach ($timeArr as $key => $value)
                        <tr>
                            <td>
                                {{ $key }}
                            </td>
                            <td>
                                {{ $value }}
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>

    </div>

@stop
