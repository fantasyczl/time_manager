@extends ('layouts.main')


@section ('title')
    时间线
@stop


@section ('content')
    @include ('layouts.messages')

    <h2>{{ $task->project->name }}</h2>

    <div class="task">
        {!! Form::open(['url' => '/tasks/' . $task->id, 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            {!! csrf_field() !!}
            
            <div class="form-group">
                <label class="col-xs-3 control-label" for="">项目名</label>
                <div class="col-xs-5">
                    {!! Form::select('project_id', $projects, $task->project_id, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">时长</label>
                <div class="col-xs-5">
                    {!! Form::text('duration', $task->duration, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-9">
                    <button class="btn btn-success" type="submit">保存</button>
                </div>
            </div>

        {!! Form::close() !!}

        <div class="delete">
            {!! Form::open(['url' => '/tasks/' . $task->id, 'method' => 'DELETE']) !!}
            <div class="form-group">
                <div class="col-xs-offset-8">
                    {!! Form::submit('删除', ['class' => 'btn-danger']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
