@extends ('layouts.base')

@section ('title')
    注册
@stop


@section ('css')
    <style>
    form {
        margin-top: 150px;
    }
    </style>
@stop

@section ('body')
    <div class="container-fluid">
        @include ('layouts.messages')

        <form method="POST" action="/auth/register" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">用户名</label>
                <div class="col-xs-5">
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>
            </div>

            <div class='form-group'>
                <label class="col-xs-3 control-label" for="">邮箱</label>
                <div class="col-xs-5">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">密码</label>
                <div class="col-xs-5">
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">确认密码</label>
                <div class="col-xs-5">
                    <input type="password" name="password_confirmation" class='form-control'>
                </div>
            </div>

            <div class='form-group'>
                <div class="col-xs-offset-3 col-xs-9">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </div>
        </form>
    </div>
@stop
