@extends ('layouts.base')

@section ('body')
    @include ('layouts.navbar')

    @include ('layouts.messages')

    <div class="container-fluid">
        @yield ('content')
    </div>
@stop
