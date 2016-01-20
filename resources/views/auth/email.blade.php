@extends ('layouts.base')

@section ('title')
    Email
@stop

@section ('body')
    <div class="container">
        <form method="POST" action="/email" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-xs-1 control-label" for="">地址</label>

                <div class="col-xs-9">
                    <input type="email" name="to" value="{{ old('to') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-1 control-label" for="">主题</label>

                <div class="col-xs-9">
                    <input type="text" name="subject" value="{{ old('subject') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-1 control-label" for="">正文</label>

                <div class="col-xs-9">
                    <textarea id="body" name="body" cols="30" rows="10" class="form-control">{{ old('body') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-9">
                    <button type="submit" class="btn btn-success">
                        Send
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop
