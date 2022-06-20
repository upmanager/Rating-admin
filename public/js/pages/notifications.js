
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
    $("input[type=radio][name=rad_notify]").on('change', e => {
        $("#fcm_container").addClass('hide');
        $("#sms_container").addClass('hide');
        $("#email_container").addClass('hide');
        $(`#${e.target.value}_container`).removeClass('hide');
    })
    $("#notification-form").on('submit', event => {
        const notify_type = $('input[name=rad_notify]:checked').val()
        const sms_users = $("#sms_users").val();
        const fcm_users = $("#fcm_users").val();
        const email_users = $("#email_users").val();
        if ((notify_type == "sms" && sms_users.length > 0) || (notify_type == "fcm" && fcm_users.length > 0) || (notify_type == "email" && email_users.length > 0)) {
            return
        }
        toastr.error('Select user!')
        event.preventDefault();
    });
});