
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $(".add-question").on('click', e => {
        editItem({ id: 0, name: '', score: 0, managerid: 0 });
    })
    $(".add-category").on('click', e => {
        editCategoryItem({ id: 0, title: '' });
    })

    $(".checkbox-users").on('change', e => {
        const checked = e.target.checked;
        const id = e.target.getAttribute('data-id');
        const questionid = e.target.getAttribute('data-questionid');
        if (id == 0) {
            $(`.checkbox-users-${questionid}`).prop('checked', checked);
        } else {
            var all_checked = true;
            $(`.checkbox-users-${questionid}`).each((idx, chk) => {
                if ($(chk).prop('checked') == false) {
                    all_checked = false;
                    return
                }
            });

            $(`#all_users_${questionid}`).prop('checked', all_checked);
        }
    })
});
const onChangeFacility = (id) => {
    const url = updateUrlParams({ category: id });
    if (url != window.location.href) {
        window.location.href = url;
    }
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
const editItem = (data) => {
    $("#question_id").val(data.id);
    $("#categoryid").val(data.categoryid);
    $("#question").val(data.question);
    $("#score").val(data.score);
    $("#update-form").modal('show');
}
const editCategoryItem = (data) => {
    $("#categoryid").val(data.id);
    $("#title").val(data.title);
    $("#require_all").prop('checked', data.all_check == 1);
    $("#add-category").modal('show');
}