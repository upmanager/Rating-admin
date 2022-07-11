
$(function () {
    var table = $("#report_table").DataTable({
        paging: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        dom: 'Bfrtip',
        lengthChange: true,
        columnDefs: [{
            targets: 1,
            orderable: false
        }],
        buttons: [
            {
                extend: 'excel',
                filename: 'Report',
                title: '',
            },
            // {
            //     extend: 'pdf',
            //     filename: 'Report',
            //     title: '',
            //     orientation: 'landscape',
            //     pageSize: 'TABLOID',
            // }
        ]
    });
    table.buttons().container().appendTo('#action-buttons');

    const _facilities_picker = $(".facilities-picker");
    const _categories_picker = $(".categories-picker");
    const _workers_picker = $(".workers-picker");
    const config = {
        actionsBox: true,
        deselectAllText: _JSLANGS.deselect_all,
        dropdownAlignRight: 'auto',
        liveSearch: true,
        selectAllText: _JSLANGS.select_all,
        width: '100%',
        noneSelectedText: _JSLANGS.nothing_selected,
        noneResultsText: _JSLANGS.mo_matched
    };
    _facilities_picker.selectpicker(config);
    _categories_picker.selectpicker(config);
    _workers_picker.selectpicker(config);


    $(".btn-filter").on('click', e => {
        const facilities = (_facilities_picker.selectpicker('val') || []).join(',');
        const categories = (_categories_picker.selectpicker('val') || []).join(',');
        const workers = (_workers_picker.selectpicker('val') || []).join(',');

        const url = updateUrlParams({ facilities, categories, workers });
        if (url != window.location.href) window.location.href = url;
    });
    $(".btn-export-pdf").on('click', e => {
        var list = table.rows().data().toArray();
        var header = table.columns().header().map(d => d.textContent).toArray();
        exportPDF([header, ...list]);
    });
    $(".fiter-empty").on('click', e => {
        const empty = e.target.getAttribute('data-isempty') == '0' ? '1' : '0';
        const url = updateUrlParams({ empty });
        if (url != window.location.href) window.location.href = url;
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

const exportPDF = (table_data) => {
    $.ajax({
        url: EXPORTPATH,
        data: { table_data },
        method: 'post',
        // headers: {
        //     'Content-disposition': 'attachment; filename=result.pdf'
        // }.
        xhr: function () {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 2) {
                    if (xhr.status == 200) {
                        xhr.responseType = "blob";
                    } else {
                        xhr.responseType = "text";
                    }
                }
            };
            return xhr;
        },
        success: function (data) {
            var blob = new Blob([data], { type: "application/octetstream" });
            var fileName = "result.pdf"
            //Check the Browser type and download the File.
            var isIE = false || !!document.documentMode;
            if (isIE) {
                window.navigator.msSaveBlob(blob, fileName);
            } else {
                var url = window.URL || window.webkitURL;
                link = url.createObjectURL(blob);
                var a = $("<a />");
                a.attr("download", fileName);
                a.attr("href", link);
                $("body").append(a);
                a[0].click();
                $("body").remove(a);
            }
            // var blob = new Blob([result]);
            // var link = document.createElement('a');
            // link.href = window.URL.createObjectURL(blob);
            // link.download = "report.pdf";
            // link.click();



            toastr.success(_JSLANGS.update_success)
            // setTimeout(() => {
            //     window.location.reload();
            // }, 1000);
        },
        error: function (xhr, status, error) {
            toastr.error('Update error' + error.toString());
        }
    });
}