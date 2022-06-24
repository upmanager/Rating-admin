
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
    $("#count").on('change', (e) => {
        const count = e.target.value || 5;
        const url = updateUrlParams({ count });
        if (url != window.location.href) {
            window.location.href = url;
        }
    })
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

const renderModal = (rating) => {
    console.log(rating);
    var html = '';
    if (rating.worker) {
        html += `
            <h3>Worker</h3>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">Name</label>
                    <label class="form-control">${rating.worker.name || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Email</label>
                    <label class="form-control">${rating.worker.email || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Phone</label>
                    <label class="form-control">${rating.worker.phonenumber || ''}</label>
                </div>
            </div>
            <hr>
        `;
    }
    if (rating.facility) {
        html += `
            <h3>Facility</h3>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">Name</label>
                    <label class="form-control">${rating.facility.name || ''}</label>
                </div>
                ${rating.facility?.Manager ? `<div class="form-group col-md-4"><label for="name">Manger Name</label><label class="form-control">${rating.facility?.Manager?.name || ''}</label></div>` : ``}
                <div class="form-group col-md-4">
                    <label for="name">Qty</label>
                    <label class="form-control">${(rating.facility.qty || 0)}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Record Number</label>
                    <label class="form-control">${rating.facility.record_number || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">License Number</label>
                    <label class="form-control">${rating.facility.license_number || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Description</label>
                    <label class="form-control">${rating.facility.content || ''}</label>
                </div>
            </div>
            <hr>
        `
    }
    html += `<h3>Rating Detail</h3>`;
    (rating.details || []).forEach(detail => {
        var data = [];
        var ismatch = false;
        if (detail.res_value == "true" || detail.res_value == true) {
            ismatch = true;
        } else if (detail.res_value != null) {
            data = (detail.res_value.split(",") || []);
        }
        html += `
        ${detail.res_key == 'location' ? (
                `<div class="form-group">
                    <label for="name">Location</label>
                    <p style="width: 100%">${detail.res_value}</p>
                </div>`
            ) : ''}
        ${detail.res_key == 'ratings' ? (
                `<h5 style="margin-top: 40px">Question:</h5>
                    <h6 style="margin-top: 40px">${detail.question?.question || ''}</h6>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <h4>${ismatch ? 'Match' : 'Non Match'}</h4>
                        </div>
                        <div class="col-md-10 row">
                        ${data.map(item => `<div class="col-md-3"><img src="${ASSETSURL}${item}" style="width:100%; height:100px; object-fit:contain" alt="" srcset=""></div>`)}
                        </div>
                        <hr>
                    </div>`
            ) : ''}
        `;
    });
    $("#detail-container").empty();
    $("#detail-container").append(html);
    $("#detail_modal").modal('show');
}