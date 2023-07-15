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
    <script src="/js/project.js?v=1"></script>

    <script>
        function orderBy() {
            loadProjects('spendTime=desc')
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
            const ids = [];
            $("#project_list_body > tr").each(function() {
                const id = $(this).attr("id");
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

        function loadProjects(query='') {
            apiProjectList('#project_list_body', query);
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
        </tbody>
    </table>
@stop
