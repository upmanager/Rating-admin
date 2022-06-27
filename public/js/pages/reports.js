
$(function () {
    var table = $("#report_table").DataTable({
        paging: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        lengthChange: false,
        buttons: [
            {
                extend: 'excel',
                filename: 'Report',
                title: '',
            },

            {
                extend: 'pdf',
                filename: 'Report',
                title: '',
                orientation: 'landscape',
                pageSize: 'TABLOID',
                customize: function (doc) {
                    doc.defaultStyle.font = "DejaVu Sans, sans-serif";
                }
            }]
    });
    table.buttons().container().appendTo('#action-buttons');

    const _facilities_picker = $(".facilities-picker");
    const _categories_picker = $(".categories-picker");
    _facilities_picker.selectpicker({
        actionsBox: true,
        deselectAllText: _JSLANGS.deselect_all,
        dropdownAlignRight: 'auto',
        liveSearch: true,
        selectAllText: _JSLANGS.select_all,
        width: '100%',
        noneSelectedText: _JSLANGS.nothing_selected,
        noneResultsText: _JSLANGS.mo_matched
    });
    _categories_picker.selectpicker({
        actionsBox: true,
        deselectAllText: _JSLANGS.deselect_all,
        dropdownAlignRight: 'auto',
        liveSearch: true,
        selectAllText: _JSLANGS.select_all,
        width: '100%',
        noneSelectedText: _JSLANGS.nothing_selected,
        noneResultsText: _JSLANGS.mo_matched
    });


    $(".btn-filter").on('click', e => {
        const facilities = (_facilities_picker.selectpicker('val') || []).join(',');
        const categories = (_categories_picker.selectpicker('val') || []).join(',');

        const url = updateUrlParams({ facilities, categories });
        if (url != window.location.href) window.location.href = url;
    });
    $(".btn-export-pdf").on('click', e => {
        console.log(table.rows().data());
    });
    $(".btn-export-excel").on('click', e => {
        console.log(table.rows().data());
    });
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