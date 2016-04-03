<!DOCTYPE html>
<html lang="zh-Hans">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="/favicon.ico" type="image/png">

        <title>
            @yield ('title')
        </title>

        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css.map" type="text/css">
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" type="text/css">

        <link rel="stylesheet" href="/css/main.css" type="text/css">

        @yield ('css')

        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="/bower_components/jquery-ui/themes/smoothness/theme.css">
        <link rel="stylesheet" href="/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css">
        <script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>

        @yield ('js')

    </head>

    <body>
        @yield ('body')
    </body>

</html>
