
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

$(function () {
    $('.daterange').daterangepicker({
        showDropdowns: true,
        locale: {
            format: "MM/DD/YYYY",
            separator: " - ",
            applyLabel: "Apply",
            cancelLabel: "Cancel",
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
        buttonClasses: "btn btn-sm "
    }, function (start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

    $(".dataTable").DataTable({
        paging: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        searching: false
    });
    const labels = rates.map(item => item.name);
    const values = rates.map(item => item.ratio);
    const options = {
        responsive: true,
        plugins: {
            legend: { position: 'top', },
            title: { display: false, }
        }
    };
    const dtSet2 = {
        // backgroundColor: _COLORS,
        // borderColor: '#fff',
        backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 205, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(201, 203, 207, 0.5)'
        ],
        borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
        ],
        data: values,
    };

    const pieConfig = {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [dtSet2]
        },
        options: options
    };

    const polarConfig = {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [dtSet2]
        },
        options: options,
    };

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
            labels: labels
        },
        options: {
            plugins: {
                legend: { position: 'top', },
                title: { display: false, }
            }
        }
    };

    new Chart(document.getElementById('polarChart'), polarConfig);
    new Chart(document.getElementById('pieChart'), pieConfig);
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