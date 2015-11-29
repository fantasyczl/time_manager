@extends ('layouts.main')


@section ('title')
    项目列表
@stop


@section ('css')
    <link rel="stylesheet" href="/bower_components/jquery-ui-1.11.4/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/bower_components/jquery-ui-1.11.4/jquery-ui.structure.min.css" type="text/css">
@stop


@section ('js')
   <script src="/bower_components/jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <script>
        $(function() {
            $('.project_row').sortable();
            $('.project_row').disableSelection();
        });
    </script>
@stop


@section ('content')
    <div><a href="/projects/create">添加项目</a></div>

    <h2>我的项目列表</h2>

    <table id="project_list" class="table table-striped">
        <tr>
            <th>项目名</th>
            <th>描述</th>
            <th>添加日期</th>
        </tr>

        @foreach ($projects as $project)
            <tr class="project_row">
                <td>
                    <a href="/projects/{{ $project->id }}">{{ $project->name }}</a>
                </td>

                <td>
                    {{ mb_substr($project->description, 0, 10) }}
                </td>

                <td>
                    {{ $project->created_at }}
                </td>
            </tr>
        @endforeach
    </table>
@stop
