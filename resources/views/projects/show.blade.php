@extends ('layouts.main')

@section ('css')
    <style>
    </style>
@stop

@section ('content')
    <a href="/projects/{{ $project->id }}/edit">编辑</a>
    <h2>项目</h2>

    <div class="project">
        <div class="row">
            <div class="col-xs-3"><label for="">项目名</label></div>
            <div class="col-xs-5">
                {{ $project->name }}
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

@stop
