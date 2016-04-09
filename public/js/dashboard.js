function addTask() {
    var id = $('select[name=task_name]').val();
    if (!id) {
        alert('请选择项目');
        return false;
    }

    $('#add_task_btn').addClass('disabled');
    $('#add_task_btn').text('添加中...');

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
                location.reload();
                return false;
            }

            location.reload();
        },
        error: function(data) {
            alert(JSON.stringify(data));
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
