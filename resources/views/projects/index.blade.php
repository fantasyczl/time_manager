@extends ('layouts.main')

@section ('title')
    项目列表
@stop

@section ('content')
    <div><a href="/projects/create">添加项目</a></div>

    <h2>我的项目列表</h2>

    <table class="table table-striped">
        <tr>
            <th>项目名</th>
            <th>描述</th>
            <th>添加日期</th>
        </tr>

        @foreach ($projects as $project)
            <tr>
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
