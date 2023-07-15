/**
 * Load project list.
 */
function apiProjectList(divId, query='') {
    $.ajax({
        url: '/time_manage_go/projects/list?' + query,
        type: 'GET',
        success: function (data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                processErrNo(data['errNo'])
                return false;
            }

            let projects = data['data']['projects'];
            displayProjectList(divId, projects);
        },
        error: function (data) {
            alert(JSON.stringify(data));
        }
    });
}

function displayProjectList(divId, projectList) {
    let s = '';
    for (let i = 0; i < projectList.length; i++) {
        const item = projectList[i];
        let sub = '<tr className="project_row" id="' + item['id'] + '">' +
            '<td>' +
            '<a href="/projects/' + item['id'] + '">' + item['name'] + '</a>' +
            '</td>' +
            '<td>' + item['statusTxt'] + '</td>' +
            '<td>' + item['description'] + '</td>' +
            '<td>' + item['spendTimeForHuman'] + '</td>' +
            '<td>' + item['createdAt'] + '</td>';
        sub += '</tr>';

        s += sub;
    }

    $(divId).html(s);
    //$(divId).css('display', 'block');
}

function showProjectTasksInDay(id, date) {
    if (typeof (date) === 'undefined') {
        date = null;
    }

    var display = $('#' + id + '_tasks').css('display');

    if (display === 'none') {
        requestProjectTaskInDay(id, date);
    } else {
        $('#' + id + '_tasks').css('display', 'none');
    }
}

function requestProjectTaskInDay(id, date) {
    if (typeof (date) === 'undefined') {
        date = null;
    }

    $.ajax({
        url: '/projects/ajax/showTasksInDay',
        type: 'GET',
        data: {id: id, date: date},
        success: function (data) {
            if (data['err_code'] != 0) {
                alert(data['message']);
                return;
            }

            showTasks(id, data);
        },
        error: function (data) {
            alert(JSON.stringify(data));
        }
    });
}

function showTasks(id, response) {
    data = response['data'];

    let s = '';
    for (let i = 0; i < data.length; i++) {
        const item = data[i];
        let sub = '<div class="row">';
        sub += '<div class="col-xs-5">' + item['start_time'] + '</div>';
        sub += '<div class="col-xs-5">Continue ' + item['duration'] + '</div>';
        sub += '</div>';

        s += sub;
    }

    const taskId = '#' + id + '_tasks';
    $(taskId).html(s);
    $(taskId).css('display', 'block');
}

function loadProject(id) {
    $.ajax({
        url: '/time_manage_go/projects/detail?id=' + id,
        type: 'GET',
        success: function (data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                processErrNo(data['errNo'])
                return false;
            }

            renderProject(data['data']['project']);
            renderDayList(data['data']['dayList']);
        },
        error: function (data) {
            alert(JSON.stringify(data));
        }
    });
}

function renderProject(project) {
    let projectTitle = "<h2>" + project.name + "</h2> "
        + '<a href="/projects/' + project.id + '/edit">Edit</a>';
    $("#project-title").html(projectTitle);
    $("#project-desc").html(project.description);

    $("#project-status").html(project.statusText)

    let projectTime = project.createdAt + '（Before Present ' + project.createdAtAgo + ')';
    $("#project-time").html(projectTime);
    $("#project-spendtime").html(project.totalDurationText);
    let avgPerDay = 'AvgDaily ' + project.avgDaily;
    $("#project-avgtime").html(avgPerDay);
}

function renderDayList(dayList) {
    let spanDays = "Span " + dayList.length + " Day";
    $("#project-spandays").html(spanDays);

    let rows = '';
    for (let i = 0; i < dayList.length; i++) {
        let item = dayList[i];
        let dayKey = item.day.replaceAll("-", "/")
        let sub = '<tr><td>'
            + '<a href="/date/' + dayKey + '">'
            + item.day + " " + item.weekday
            + '</a>'
            + '</td>'
            + '<td>' + item.timeLen + '</td>'
            + '</tr>';

        rows += sub;
    }
    $('#daylist-tbody').html(rows);
}
