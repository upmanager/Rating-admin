
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
    $(".add-facility").on('click', e => {
        editItem({ id: 0, name: '', managerid:0 });
    })
});

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
const editItem = (data) => {
    if(data.id > 0) {
        $(".default-password").addClass("hide");
        $(".reset-password").removeClass("hide");
    } else {
        $(".default-password").removeClass("hide");
        $(".reset-password").addClass("hide");
    }
    $("#id").val(data.id);
    $("#name").val(data.name);
    $("#managerid").val(data.managerid);
    $("#update-form").modal('show');
}