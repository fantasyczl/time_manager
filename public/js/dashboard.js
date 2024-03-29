$(function () {
    let inputTimes = 0;
    let taskTimeId = $('input[name=task_time]');

    taskTimeId.on('click', function () {
        inputTimes = 0;
        let val = $(this).val();

        if (val === '') {
            return;
        }

        let e = document.getElementById($(this).attr('id'));
        if (!e) {
            alert('e == null');
            return;
        }

        setInputSelection(e, 0, 2);
    });

    taskTimeId.on('keyup', function (event) {
        inputTimes++;

        console.log(event)
        console.log('inputTimes: ', inputTimes)
        if (inputTimes >= 2) {
            let e = document.getElementById($(this).attr('id'));
            if (!e) {
                alert('e == null');
                return;
            }

            if (inputTimes % 2 === 0) {
                setInputSelection(e, 3, 5);
                inputTimes = 0
            }
        }
    });

    loadLeastTaskList();
    loadTodayProjects();
});

function addTask() {
    let id = $('select[name=task_name]').val();
    if (!id) {
        alert('Please select project!');
        return false;
    }

    setAddTaskBtn(true);

    var date = $('input[name=task_date]').val();
    var time = $('input[name=task_time]').val();

    var dateTime = '';

    var display = $('#time_label').css('display');

    if (date && time && display != 'none')
        dateTime = date + ' ' + time;

    $.ajax({
        url: '/time_manage_go/tasks',
        type: 'POST',
        data: {'project_id': id, 'date_time': dateTime},
        success: function (data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                setAddTaskBtn(false);
                processErrNo(data['errNo'])
                return false;
            }

            location.reload();
        },
        error: function (data) {
            alert(JSON.stringify(data));
            location.reload();
        }
    });
}


function showTimeLabel() {
    let obj = $('#time_label');
    if (obj.css('display') === 'none') {
        obj.css('display', 'block');
    } else {
        obj.css('display', 'none');
    }
}

function setInputSelection(input, startPos, endPos) {
    if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', endPos);
        range.moveStart('character', startPos);
        range.select();
    } else if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(startPos, endPos, 'forward');
    } else if (typeof input.selectionStart != 'undefined') {
        input.selectionStart = startPos;
        input.selectionEnd = endPos;
    } else {
        console.log("neither support", input, startPos, endPos)
    }
}


function setAddTaskBtn(isActive) {
    if (isActive) {
        $('#add_task_btn').addClass('disabled');
        $('#add_task_btn').text('Adding...');
    } else {
        $('#add_task_btn').removeClass('disabled');
        $('#add_task_btn').text('Add');
    }
}

function loadLeastTaskList() {
    $.ajax({
        url: '/time_manage_go/tasks',
        type: 'GET',
        success: function (data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                processErrNo(data['errNo'])
                return false;
            }

            renderTaskList(data['data']['tasks'])

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

function renderTaskList(taskList) {
    s = '';
    for (let i = 0; i < taskList.length; i++) {
        task = taskList[i]
        s += '<div class="row">'
            + '<div class="col-xs-2 col-md-1">'
            + '<a href="/tasks/' + task.id + '">' + task.id + '</a>'
            + '</div>'
            + '<div class="col-xs-4 col-md-4">' + task.startTime + '</div>'
            + '<div class="col-xs-2 col-md-3">'
            + '<a href="/projects/' + task.projectID + '">' + task.projectName + '</a>'
            + '</div>'
            + '<div class="col-xs-4 col-md-4">' + task.durationDesc + '</div>'
            + '</div>';
    }

    $("#task_list_body").html(s);
}

function loadTodayProjects() {
    $.ajax({
        url: '/time_manage_go/projects/day',
        type: 'GET',
        success: function (data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                processErrNo(data['errNo'])
                return false;
            }

            renderTodayProjectTitle(data['data']['day'], data['data']['weekday']);
            renderTodayProjectList(data['data']['list']);
        },
        error: function (data) {
            alert(JSON.stringify(data));
        }
    });
}

function renderTodayProjectTitle(day, weekday) {
    $("#today_project_title").html(day + " " + weekday);
}

function renderTodayProjectList(projectList) {
    s = ''
    for (let i = 0; i < projectList.length; i++) {
        project = projectList[i];

        s += '<div class="row">'
            + '<div class="col-xs-5">'
            + '<a href="/projects/' + project.id + '">'
            + '<label for="">' + project.name + '</label>'
            + '</a>'
            + '</div>'
            + '<div class="col-xs-5">'
            + '<label for="">'
            + '<a href="javascript:void(0);" onclick="showProjectTasksInDay(' + project.id + ');">'
            + '共' + project.durationHuman
            + '</a>'
            + '</label>'
            + '</div>'
            + '</div>'
            + '<div id="' + project.id + '_tasks" class="row project-task-in-day" style="display: none;"></div>'
        ;
    }

    $("#today_project_list").html(s);
}
