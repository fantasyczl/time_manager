@extends ('layouts.main')

@section ('title')
    User: {{ $user->name }}
@stop

@section ('content')
    @include ('layouts.messages')

    <div class="user">
        <div class="title">
            <h2>User: {{ $user->name }}</h2>
            <a href="/users/{{ $user->id }}/edit">Edit</a>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <label for="">User Name</label>
            </div>
            <div class="col-xs-9">{{ $user->name }}</div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <label for="">Email</label>
            </div>
            <div class="col-xs-9">{{ $user->email }}</div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <label for="">Created At</label>
            </div>
            <div class="col-xs-9">
                {{ $user->created_at }}
            </div>
        </div>
    </div>
@stop
