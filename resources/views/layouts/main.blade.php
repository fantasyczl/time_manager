@extends ('layouts.base')

@section ('body')
    @include ('layouts.navbar')

    <div class="container-fluid">
        @yield ('content')
    </div>
@stop
