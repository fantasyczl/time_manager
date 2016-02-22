@extends ('layouts.main')

@section ('title')
    Create Schedule
@stop

@section ('content')
    <div class="container-fluid">
        <h2>Create Schedule</h2>

        <form method="POST" action="/schedules" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-xs-3 control-label" for="">Name</label>
                <div class="col-xs-5">
                    <input type="text" name="name" class="form-control" required>
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
