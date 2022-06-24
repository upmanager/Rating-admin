
function shuffle(array) {
    let currentIndex = array.length, randomIndex;

    // While there remain elements to shuffle.
    while (currentIndex != 0) {

        // Pick a remaining element.
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
    }

    return array;
}

var _COLORS = shuffle(['#FF1493', '#FF00FF', '#DC143C', '#FF7F50', '#FFFF00', '#7FFF00', '#00FFFF', '#1E90FF']);
var start_time = null
var end_time = null
$(function () {
    const _dRange = $('.daterange');
    const _picker = $(".facilities-picker");
    _dRange.daterangepicker({
        showDropdowns: true,
        locale: {
            format: "MM/DD/YYYY",
            separator: " - ",
            applyLabel: "Apply",
            cancelLabel: 'Clear',
            fromLabel: "From",
            toLabel: "To",
            customRangeLabel: "Custom",
            weekLabel: "W",
            daysOfWeek: [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            monthNames: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            firstDay: 1
        },
        maxDate: "06/04/2022",
        opens: "center",
        buttonClasses: "btn btn-sm",
        autoUpdateInput: false,
    });

    _dRange.on('apply.daterangepicker', function (ev, picker) {
        _dRange.val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
    _dRange.on('cancel.daterangepicker', (ev, picker) => {
        _dRange.val('')
    });

    $(".dataTable").DataTable({
        paging: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        searching: false
    });
    _picker.selectpicker({
        actionsBox: true,
        deselectAllText: 'Deselect All',
        dropdownAlignRight: 'auto',
        liveSearch: true,
        selectAllText: 'Select All',
        width: '100%'
    });

    $(".btn-filter").on('click', e => {
        const facilities = (_picker.selectpicker('val') || []).join(',');
        const start_date = _dRange.val() ? _dRange.data('daterangepicker').startDate.format('MM/DD/YYYY') : null;
        const end_date = _dRange.val() ? _dRange.data('daterangepicker').endDate.format('MM/DD/YYYY') : null;

        const url = updateUrlParams({ facilities, start_date, end_date });
        if (url != window.location.href) window.location.href = url;
    });

    const mixedConfig = {
        data: {
            datasets: [
                {
                    type: 'line',
                    label: 'Max Rate',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: rates.map(item => item.total_rate)
                },
                {
                    type: 'line',
                    label: 'Current Rate',
                    backgroundColor: 'rgb(153, 102, 255)',
                    borderColor: 'rgb(153, 102, 255)',
                    data: rates.map(item => item.rate)
                }

            ],
            labels: rates.map(item => item.name)
        },
        options: {
            plugins: {
                legend: { position: 'top', },
                title: { display: false, }
            }
        }
    };

    new Chart(document.getElementById('mixedChart'), mixedConfig);

    const dateChartConfig = {
        data: {
            datasets: [
                {
                    type: 'line',
                    label: 'Max Rate',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: rate_by_date.map(item => item.total_rate)
                },
                {
                    type: 'line',
                    label: 'Current Rate',
                    backgroundColor: 'rgb(153, 102, 255)',
                    borderColor: 'rgb(153, 102, 255)',
                    data: rate_by_date.map(item => item.rate)
                }

            ],
            labels: rate_by_date.map(item => item.date)
        },
        options: {
            plugins: {
                legend: { position: 'top', },
                title: { display: false, }
            }
        }
    };
    new Chart(document.getElementById('chartbydate'), dateChartConfig);
});

function updateUrlParams(obj) {
    let curParams = new URLSearchParams(window.location.search);

    Object.entries(obj).map(([key, value]) => {
        if (value == null || value == '') curParams.delete(key);
        else curParams.set(key, value);
    })

    const { protocol, host, pathname } = window.location;
    const url = `${protocol}//${host}${pathname}?${curParams.toString()}`;
    return url;
}