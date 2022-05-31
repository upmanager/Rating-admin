
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $(".add-facility").on('click', e => {
        editItem({ id: 0, name: '', managerid: 0 });
    })
    $(".block-rating").on('click', e => {
        const id = $(e.target).attr('tag');
        ratingAction(id, false);
    });
    $(".approve-rating").on('click', e => {
        const id = $(e.target).attr('tag');
        ratingAction(id, true);
    });
});
const ratingAction = (id, approve) => {
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
function updateUrlParams(obj) {
    let curParams = new URLSearchParams(window.location.search);

    Object.entries(obj).map(([key, value]) => {
        curParams.set(key, value);
    })

    const { protocol, host, pathname } = window.location;
    const url = `${protocol}//${host}${pathname}?${curParams.toString()}`;
    return url;
}
const onChangeFacility = (id) => {
    const url = updateUrlParams({ facility: id });
    if (url != window.location.href) {
        window.location.href = url;
    }
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