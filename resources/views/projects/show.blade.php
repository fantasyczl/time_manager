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
        <h2>{{ $project->name }}</h2>
        <a href="/projects/{{ $project->id }}/edit">Edit</a>
    </div>

    <div class="project">
        <div class="row">
            <div class="col-xs-3"><label for="">Description</label></div>
            <div class="col-xs-5">
                {{ $project->description }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"><label for="">Status</label></div>
            <div class="col-xs-5">
                {{ $project->statusDisplay() }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"><label for="">Created At</label></div>
            <div class="col-xs-5">
                {{ \App\Lib\Utils\TimeUtils::GetLocalTime($project->created_at) }}
                （Before Present {{ \App\Lib\Utils\TimeUtils::diffForHuman($project->created_at) }}）
            </div>
        </div>
    </div>

    <hr>

    <div class="time-seciton">
        <h4>Spend Time</h4>

        <div class="row">
            <div class="col-xs-3 col-md-1"><label for="">TotalSpend</label></div>

            <div class="col-xs-3 col-md-2">
                {{ $project->spendTimeForHuman() }}
            </div>

            <div class="col-xs-3 col-md-2">
                Span {{count($timeArr)}} Day
            </div>

            <div class="col-xs-3 col-md-2">
                <?php
                $durationPerDay = 0;
                if (count($timeArr) > 0) {
                    $durationPerDay = $project->spendTime() / count($timeArr);
                }
                $timeHuman = \App\Lib\Utils\TimeUtils::durationForHuman($durationPerDay);
                ?>
                AvgDaily {{ $timeHuman }}
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6">

                <table class="table table-striped">
                    <tr>
                        <th>Date</th>
                        <th>Spend</th>
                    </tr>

                    @foreach ($timeArr as $key => $value)
                        <tr>
                            <td>
                                <a href="/date/{{str_replace('-', '/', $key)}}">
                                    {{ $key }}
                                    {{ \App\Lib\Utils\TimeUtils::GetLocalWeekDay($key) }}
                                </a>
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
