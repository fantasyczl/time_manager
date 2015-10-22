@extends ('layouts.base')

@section ('title')
    Login
@stop

@section ('css')
    <style>
    .form {
        margin-top: 150px;
    }
    </style>
@stop

@section ('body')
    <div class="content-fluid">

        @include ('layouts.messages')

        <form method="POST" action="/auth/login" class="form-horizontal form">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">邮箱</label>

                <div class="col-xs-3">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">密码</label>
                <div class="col-xs-3">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-xs-9">
                    <div class="checkbox">
                        <label for="remember">
                            <input id="remember" type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-9">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-9">
                    <a href="/auth/register">注册</a>
                </div>
            </div>
        </form>

    </div>
@stop
