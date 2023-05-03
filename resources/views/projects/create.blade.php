@extends ('layouts.base')

@section ('title')
    Create Project
@stop

@section ('js')
    <script>
        function submit() {

        }

        $(function () {
        });
    </script>
@stop

@section ('body')
    <div class="container-fluid">
        <h2>Create Project</h2>

        <form method="POST" action="/projects" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Project</label>
                <div class="col-xs-5">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Status</label>
                <div class="col-xs-5">
                    {!! Form::select('status', \App\Models\Project::STATUSES, null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Description</label>
                <div class="col-xs-5">
                    <textarea id="" name="description" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-8">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>

        </form>
    </div>
@stop
