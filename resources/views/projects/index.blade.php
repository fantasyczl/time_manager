@extends ('layouts.main')


@section ('title')
    Projects
@stop


@section ('css')
    <link rel="stylesheet" href="/bower_components/jquery-ui-1.11.4/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/bower_components/jquery-ui-1.11.4/jquery-ui.structure.min.css" type="text/css">
@stop


@section ('js')
    <script src="/bower_components/jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <script>
        function orderBy() {
            var url = curUrl();
            url += "?spendTime=desc";

            window.location = url;
        }

        function curUrl() {
            var url = window.location.href;
            var index = url.indexOf('?');
            if (index == -1) {
                return url;
            } else {
                return url.substring(0, index);
            }
        }

        function saveOrders() {
            var ids = [];
            $("#project_list_body > tr").each(function() {
                var id = $(this).attr("id");
                ids.push(id);
            });

            $.ajax({
                url: '/projects/ajax/saveOrders',
                type: 'PUT',
                data: {ids: ids},
                success: function(data) {
                    if (data['status'] == 0) {
                        alert("Save Success!");
                    }
                },
                error: function(error) {
                    alert(JSON.stringify(error));
                }
            });
        }

        function loadProjects() {


        }
    
        $(function() {
            $("#project_list_body").sortable({
                update: function(event, ui) {
                    //saveOrders();
                }
            });
            $("#project_list_body").disableSelection();
            loadProjects();
        });

    </script>
@stop


@section ('content')
    <div>
        <a href="/projects/create">Add Project</a>
        &nbsp;&middot;&nbsp;
        <a class="btnkbtn-normal" href="#" onclick="saveOrders(); return false;">Save Order</a>
    </div>

    <div>
        <h2>Project List</h2>
    </div>

    <table id="project_list" class="table table-striped">
        <tr>
            <th>Project</th>
            <th>Status</th>
            <th>Description</th>
            <th>
                <a href="javascript:void(0);" onclick="orderBy();">Spend Time</a>
            </th>
            <th>Created Time</th>
        </tr>

        <tbody id="project_list_body">
            @foreach ($projects as $project)
                <tr class="project_row" id="{{ $project->id }}">
                    <td>
                        <a href="/projects/{{ $project->id }}">{{ $project->name }}</a>
                    </td>
                    <td>
                        {{ \App\Models\Project::STATUSES[$project->status] ?? 'Unknown' }}
                    </td>
                    <td>
                        {{ mb_substr($project->description, 0, 10) }}
                    </td>
                    <td>
                        {{ $project->spendTimeForHuman() }}
                    </td>
                    <td>
                        {{ $project->created_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
