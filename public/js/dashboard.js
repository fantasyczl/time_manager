$(function() {
    var inputTimes = 0;
    var taskTimeId = $('input[name=task_time]');
    taskTimeId.on('click', function() {
        inputTimes = 0;
        var val = $(this).val();

        if (val === '') {
            return;
        }

        var e = document.getElementById($(this).attr('id'));
        if (!e) {
            alert('e == null');
            return;
        }

        setInputSelection(e, 0, 2);
    });

    taskTimeId.on('keyup', function(e) {
        inputTimes++;
        if (inputTimes >= 2) {
            var e = document.getElementById($(this).attr('id'));
            if (!e) {
                alert('e == null');
                return;
            }

            if (inputTimes % 2 == 0) {
                setInputSelection(e, 3, 5);
            }
        }
    });
    loadLeastTaskList();
});

function addTask() {
    var id = $('select[name=task_name]').val();
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
        url: '/tasks/ajax/addTask',
        type: 'POST',
        data: {'project_id': id, 'date_time': dateTime},
        success: function(data) {
            if (data['err_code'] !== 0) {
                alert(data['message']);
                setAddTaskBtn(false);
                return false;
            }

            location.reload();
        },
        error: function(data) {
            alert(JSON.stringify(data));
            location.reload();
        }
    });
}


function showTimeLabel() {
    var obj = $('#time_label');
    if (obj.css('display') == 'none') 
        obj.css('display', 'block')
    else
        obj.css('display', 'none')
}

function setInputSelection(input, startPos, endPos) {
    if (input.createTextRange) {
        var range = e.createTextRange();
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
        success: function(data) {
            if (data['errNo'] !== 0) {
                alert(data['errMsg']);
                return false;
            }

            renderTaskList(data['data']['tasks'])

        },
        error: function(data) {
            alert(JSON.stringify(data));
        }
    });
}

function renderTaskList(taskList) {
    s = '';
    for (let i = 0; i < taskList.length; i++) {
        task = taskList[i]
        s +=  '<div class="row">'
            + '<div class="col-xs-2 col-md-1">'
            + '<a href="/tasks/' + task.ID + '">' + task.ID + '</a>'
            + '</div>'
            + '<div class="col-xs-4 col-md-4">' + task.StartTime + '</div>'
            + '<div class="col-xs-2 col-md-3">'
            + '<a href="/projects/{{ $task->project->id }}">' + task.ProjectName + '</a>'
            + '</div>'
            + '<div class="col-xs-4 col-md-4">' + task.DurationDesc + '</div>'
            + '</div>';
    }

    $("#task_list_body").html(s);
}
