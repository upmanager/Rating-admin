
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
    $("#update_password").on('change', e => {
        $("#password").val('');
        $("#password").prop("disabled", !e.target.checked);
        if (e.target.checked) {
            $('#password').prop('required', true);
        } else {
            $('#password').removeAttr('required');
        }
    })
    $(".add-user").on('click', e => {
        editItem({ id: 0, role: 0 });
    })
});

const userAction = (id, approve) => {
    $.ajax({
        url: UPDATEPATH,
        data: { id, approve },
        method: 'put',
        success: function (result) {
            toastr.success('update success')
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        },
        error: function (xhr, status, error) {
            toastr.error('Update error' + error.toString());
        }
    });
}
const deleteItem = (ele) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            ele.parentElement.submit()
        }
    })
}
const editItem = (user) => {
    $("#password").prop("disabled", user.id > 0);
    $("#update_password").prop('checked', user.id <= 0);
    if (user.id > 0) {
        $('#password').removeAttr('required');
        $(".update-password").removeClass("hide");
        $(".new-password").addClass("hide");
    } else {
        $(".update-password").addClass("hide");
        $(".new-password").removeClass("hide");
        $('#password').prop('required', true);
    }
    $("#userid").val(user.id);
    $("#username").val(user.name);
    $("#useremail").val(user.email);
    $("#userrole").val(user.role);
    $("#update-form").modal('show');
}