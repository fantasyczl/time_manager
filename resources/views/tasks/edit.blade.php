@extends ('layouts.main')


@section ('title')
    Time Line
@stop


@section ('content')
    @include ('layouts.messages')

    <h2>{{ $task->project->name }}</h2>

    <div class="task">
        {!! Form::open(['url' => '/tasks/' . $task->id, 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            {!! csrf_field() !!}
            
            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Project</label>
                <div class="col-xs-5">
                    {!! Form::select('project_id', $projects, $task->project_id, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Duration</label>
                <div class="col-xs-5">
                    @if ($isShowDeleteBtn)
                        {!! Form::text('duration', $task->duration, ['class' => 'form-control']) !!}
                    @else
                        <div class="form-control">{{ $task->duration }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-9">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </div>

        {!! Form::close() !!}

        @if ($isShowDeleteBtn)
        <div class="delete">
            {!! Form::open(['url' => '/tasks/' . $task->id, 'method' => 'DELETE']) !!}
            <div class="form-group">
                <div class="col-xs-offset-8">
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        @endif
    </div>
@stop
