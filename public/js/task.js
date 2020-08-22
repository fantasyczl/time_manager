$(function () {
    loadDetail(taskID);
});

function loadDetail(id) {
    $.ajax({
        url: '/time_manage_go/tasks/' + id,
        type: 'GET',
        success: function (data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                processErrNo(data['errNo'])
                return false;
            }

            render(data['data'])
        },
        error: function (data) {
            alert(JSON.stringify(data));
        }
    });
}

function processErrNo(errNo) {
    if (errNo == 1) {
        location.reload();
        return
    }
}

function render(task) {
    s = '<div class="title">'
        + '<h2>Task: '+ task.project.name + '</h2>'
        + '<a href="/tasks/' + task.id + '/edit">Edit</a>'
        + '</div>'
        + '<div class="row">'
        + '<div class="col-xs-3">'
        + '<label for="">Project Name</label>'
        + '</div>'
        + '<div class="col-xs-9">' + task.project.name + '</div>'
        + '</div>'
        + '<div class="row">'
        + '<div class="col-xs-3">'
        + '<label for="">Start At</label>'
        + '</div>'
        + '<div class="col-xs-9">' + task.startTime + '</div>'
        + '</div>'
        + '<div class="row">'
        + '<div class="col-xs-3">'
        + '<label for="">Continue</label>'
        + '</div>'
        + '<div class="col-xs-9">' + task.durationDesc + '</div>'
        + '</div>'
        + '</div>';

    $("#task_dev").html(s);
}
