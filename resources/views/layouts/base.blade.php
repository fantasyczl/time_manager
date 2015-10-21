<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            @yield ('title')
        </title>

        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css.map" type="text/css">
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" type="text/css">

        @yield ('css')

        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/bower_components/bootstrap/dist/js/npm.js"></script>

        @yield ('js')

    </head>

    <body>
        @yield ('body')
    </body>

</html>
