@extends ('layouts.main')

@section ('css')
    <style>
    </style>
@stop

@section ('content')
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
    </div>

@stop
