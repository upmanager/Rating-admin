
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
    $("#status").on('change', (e) => {
        const status = e.target.value || 0;
        const url = updateUrlParams({ status });
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
            toastr.success(_JSLANGS.update_success)
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        },
        error: function (xhr, status, error) {
            toastr.error('Update error' + error.toString());
        }
    });
}
const onChangeFacility = (id) => {
    const url = updateUrlParams({ facility: id });
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

const renderModal = (rating) => {
    console.log(rating);
    var html = '';
    if (rating.worker) {
        html += `
            <h3>${_LANLABELS.Worker}</h3>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.Name}</label>
                    <label class="form-control">${rating.worker.name || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.Email}</label>
                    <label class="form-control">${rating.worker.email || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.Phone}</label>
                    <label class="form-control">${rating.worker.phonenumber || ''}</label>
                </div>
            </div>
            <hr>
        `;
    }
    if (rating.facility) {
        html += `
            <h3>${_LANLABELS.Facility}</h3>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.Name}</label>
                    <label class="form-control">${rating.facility.name || ''}</label>
                </div>
                ${rating.facility?.Manager ? `<div class="form-group col-md-4"><label for="name">${_LANLABELS.manager_name}</label><label class="form-control">${rating.facility?.Manager?.name || ''}</label></div>` : ``}
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.record_number}</label>
                    <label class="form-control">${rating.facility.record_number || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.license_number}License Number</label>
                    <label class="form-control">${rating.facility.license_number || ''}</label>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">${_LANLABELS.description}</label>
                    <label class="form-control">${rating.facility.content || ''}</label>
                </div>
            </div>
            <hr>
        `
    }
    html += `<h3>${_LANLABELS.rating_detail}</h3>`;
    (rating.details || []).forEach(detail => {
        var data = [];
        if (data.res_key == 'none') return;

        if (detail.res_key == "nonmatch" && detail.res_value) data = (detail.res_value.split(",") || []);

        html += detail.res_key == 'location' ?
            `<div class="form-group"><label for="name">${_LANLABELS.Location}</label><p style="width: 100%">${detail.res_value}</p></div>`
            :
            (
                `<h5 style="margin-top: 40px">Question:</h5>
                    <h6 style="margin-top: 40px">${detail.question?.question || ''}</h6>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <h4>${detail.res_key == "match" ? _LANLABELS.match : detail.res_key == "average" ? _LANLABELS.average : _LANLABELS.no_match}</h4>
                        </div>
                        <div class="col-md-10 row">
                        ${data.map(item => `<div class="col-md-3"><img src="${ASSETSURL}${item}" style="width:100%; height:100px; object-fit:contain" alt="" srcset=""></div>`)}
                        </div>
                        <hr>
                    </div>`
            );
    });
    $("#detail-container").empty();
    $("#detail-container").append(html);
    $("#detail_modal").modal('show');
}