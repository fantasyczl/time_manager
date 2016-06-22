function showProjectTasksInDay(id, date = null)
{
    var display = $('#'+id+'_tasks').css('display');

    if (display == 'none') {
        requestProjectTaskInDay(id, date);
    } else {
        $('#'+id+'_tasks').css('display', 'none');
    }
}

function requestProjectTaskInDay(id, date = null)
{
    $.ajax({
        url: '/projects/ajax/showTasksInDay',
        type: 'GET',
        data: {id: id, date: date},
        success: function(data) {
            if (data['err_code'] != 0) {
                alert(data['message']);
                return;
            }

            showTasks(id, data);
        },
        error: function(data) {
            alert(JSON.stringify(data));
        }
    });
}

function showTasks(id, response)
{
    data = response['data'];

    var s = '';
    for (i = 0; i < data.length; i++) {
        var item = data[i];
        var sub = '<div class="row">';
        sub += '<div class="col-xs-5">' + item['start_time'] + '</div>';
        sub += '<div class="col-xs-5">持续' + item['duration'] + '</div>';
        sub += '</div>';

        s += sub;
    }

    $('#'+id+'_tasks').html(s);
    $('#'+id+'_tasks').css('display', 'block');
}
