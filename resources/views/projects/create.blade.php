@extends ('layouts.base')


@section ('body')
    <div class="container-fluid">
        <h2>创建项目</h2>

        <form method="POST" action="/projects" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">项目名</label>
                <div class="col-xs-5">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">描述</label>
                <div class="col-xs-5">
                    <textarea id="" name="description" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-8">
                    <button class="btn btn-success">保存</button>
                </div>
            </div>

        </form>
    </div>
@stop
