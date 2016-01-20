@extends ('layouts.base')

@section ('title')

@stop

@section ('css')
    <link rel="stylesheet" href="/css/login.css" type="text/css">
    <style>
    </style>
@stop

@section ('body')
    <div class="container">

        <form method="POST" action="/password/email" class="form-horizontal">
            {!! csrf_field() !!}

            @include ('layouts.messages')

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">邮箱</label>

                <div class="col-xs-9">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-9">
                    <button type="submit" class="btn btn-success">
                        Send Password Reset Link
                    </button>
                </div>
            </div>

        </form>
    </div>
@stop
