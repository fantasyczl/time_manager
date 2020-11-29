@extends ('layouts.main')

@section ('title')
    Project Detail
@stop

@section ('css')
    <style>
    </style>
@stop

@section ('js')
    <script src="/js/project.js?v=3"></script>
    <script>
        var projectID =<?php echo $id;?>

        $(function () {
            loadProject(projectID);
        });
    </script>
@stop

@section ('content')
    <div class="title" id="project-title">
    </div>

    <div class="project">
        <div class="row">
            <div class="col-xs-3"><label for="">Description</label></div>
            <div class="col-xs-5" id="project-desc">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"><label for="">Status</label></div>
            <div class="col-xs-5" id="project-status">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"><label for="">Created At</label></div>
            <div class="col-xs-5" id="project-time">
            </div>
        </div>
    </div>

    <hr>

    <div class="time-seciton">
        <h4>Spend Time</h4>

        <div class="row">
            <div class="col-xs-3 col-md-1"><label for="">TotalSpend</label></div>

            <div class="col-xs-3 col-md-2" id="project-spendtime">
            </div>

            <div class="col-xs-3 col-md-2" id="project-spandays">
            </div>

            <div class="col-xs-3 col-md-2" id="project-avgtime">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6">

                <table class="table table-striped" id="daylist-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Spend</th>
                        </tr>
                    </thead>

                    <tbody id="daylist-tbody">
                    </tbody>
                </table>

            </div>
        </div>

    </div>

@stop
