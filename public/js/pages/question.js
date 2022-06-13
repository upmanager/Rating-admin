
$(function () {
    $(".dataTable").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $(".add-question").on('click', e => {
        editItem({ id: 0, name: '', managerid: 0 });
    })
});
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
    const url = updateUrlParams({ category: id });
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
const editItem = (data) => {
    console.log(data.id);
    $("#question_id").val(data.id);
    $("#categoryid").val(data.categoryid);
    $("#question").val(data.question);
    $("#update-form").modal('show');
}