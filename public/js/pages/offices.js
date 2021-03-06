
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $(".add-office").on('click', e => {
        editItem({ id: 0, name: '', managerid: 0 });
    })
    $(".checkbox-users").on('change', e => {
        const checked = e.target.checked;
        const id = e.target.getAttribute('data-id');
        const facilityid = e.target.getAttribute('data-facilityid');
        if (id == 0) {
            $(`.checkbox-users-${facilityid}`).prop('checked', checked);
        } else {
            var all_checked = true;
            $(`.checkbox-users-${facilityid}`)
                .each((idx, chk) => {
                    if ($(chk).prop('checked') == false) {
                        all_checked = false;
                        return
                    }
                });
            $(`#all_users_${facilityid}`).prop('checked', all_checked);
        }
    })
});
const onChangeFacility = (id) => {
    const url = updateUrlParams({ facility: id });
    if (url != window.location.href) {
        window.location.href = url;
    }
}
const editItem = (data) => {
    $("#office_id").val(data.id);
    $("#facilityid").val(data.facilityid);
    $("#office").val(data.name);
    $("#update-form").modal('show');
}
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