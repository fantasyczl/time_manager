@extends ('layouts.main')

@section ('title')
    Time Line
@stop

@section ('content')
    @include ('layouts.messages')

    <h2>{{ $user->name }}</h2>

    <div class="user">
        {!! Form::open(['url' => '/users/' . $user->id, 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
            {!! csrf_field() !!}
            
            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Name</label>
                <div class="col-xs-5">
                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Email</label>
                <div class="col-xs-5">
                    {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
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
