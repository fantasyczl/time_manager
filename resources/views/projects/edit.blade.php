@extends ('layouts.main')

@section ('title')
    Edit -- {{ $project->name }}
@stop


@section ('content')

    @include ('layouts.messages')

    <h2>Edit -- {{ $project->name }}</h2>

    <div class="project">
        {!! Form::open(['url' => '/projects/' . $project->id, 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            {!! csrf_field() !!}
            
            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Name</label>
                <div class="col-xs-5">
                    <input class="form-control" type="text" name="name" value="{{ $project->name }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Description</label>
                <div class="col-xs-5">
                    <textarea id="description" name="description" cols="30" rows="5" class="form-control">{{ $project->description }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-9">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@stop
