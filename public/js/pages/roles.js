
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

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
    if(user.id > 0) {
        $(".default-password").addClass("hide");
        $(".reset-password").removeClass("hide");
    } else {
        $(".default-password").removeClass("hide");
        $(".reset-password").addClass("hide");
    }
    $("#userid").val(user.id);
    $("#username").val(user.name);
    $("#useremail").val(user.email);
    $("#userrole").val(user.role);
    $("#update-form").modal('show');
}