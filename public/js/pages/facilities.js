
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
    $(".add-facility").on('click', e => {
        editItem({ id: 0, name: '', managerid: 0, license_number: '', record_number: '', content: '' });
    })
});

const deleteItem = (ele) => {
    Swal.fire({
        title: _JSLANGS.del_confirm,
        text: _JSLANGS.del_msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: _JSLANGS.del_button
    }).then((result) => {
        if (result.isConfirmed) {
            ele.parentElement.submit()
        }
    })
}
const editItem = (data) => {
    $("#id").val(data.id);
    $("#name").val(data.name);
    $("#managerid").val(data.managerid);
    $("#license_number").val(data.license_number);
    $("#record_number").val(data.record_number);
    $("#content").val(data.content);

    $("#update-form").modal('show');
}