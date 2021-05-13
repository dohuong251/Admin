let startDate = moment().startOf('month'), endDate = moment(), viewChart, viewChartOptions = {
    width: '50%',
    markers: {
        size: 4,
        hover: {
            size: 8
        }
    },
    chart: {
        height: 350,
        type: 'line',
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [],
    xaxis: {
        type: 'datetime',
        labels: {
            datetimeFormatter: {
                year: 'yyyy',
                month: 'MM/yyyy',
                day: 'dd/MM',
                hour: 'HH:mm'
            }
        }
    },
    yaxis: [{
        decimalsInFloat: 0,
        title: {
            text: 'Success Views',
        },
        labels: {
            formatter: value => {
                if (value) return `${value.toLocaleString()}`;
                else return value;
            }
        }
    }, {
        opposite: true,
        title: {
            text: 'Success Rate'
        },
        labels: {
            formatter: value => {
                if (value) return `${value} %`;
                else return value;
            }
        }
    }],
    fill: {
        opacity: 1
    },
    tooltip: {
        x: {
            format: "dd/MM"
        }
    }
};

$(document).ready(function () {
    // init stream chart
    viewChart = new ApexCharts(
        document.querySelector(".stream-chart"),
        viewChartOptions
    );
    viewChart.render();

    // loadData();

    $('#date-picker').daterangepicker({
        "linkedCalendars": false,
        ranges: {
            'Hôm Nay': [moment(), moment()],
            'Hôm Qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tuần Này': [moment().startOf('week'), moment().endOf('week')],
            'Tháng Này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng Trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        },
        locale: {
            cancelLabel: 'Clear'
        },
        "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "startDate": startDate,
        "endDate": endDate,
        maxDate: moment(),
    })
        .on('apply.daterangepicker', function (ev, picker) {
            if (picker) {
                if (picker.startDate) startDate = picker.startDate;
                if (picker.endDate) endDate = picker.endDate;
            }

            $(this).val(startDate.format(localeDateFormat) + ' - ' + endDate.format(localeDateFormat));
        })
        .on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        })
        .trigger('apply.daterangepicker');

    $('#streamSearch').select2({
        width: '100%',
        placeholder: "Tìm theo tên kênh",
        allowClear: true,
        ajax: {
            cache: true,
            delay: 500,
            url: ajaxSearchUrl,
            data: function (params) {
                return {
                    query: params.term,
                    type: 1,
                    page: params.page || 1
                }
            },
            dataType: 'json',
        }
    });
});

let loadDataRequest,
    rankStreamTemplate = Handlebars.compile(document.getElementById("stream-rank-template").innerHTML);

Handlebars.registerHelper('number_format_duration', function (duration) {
    if (duration) {
        try {
            return new Handlebars.SafeString((duration / 1000).toLocaleString().split(".")[0]);
        } catch (e) {
            console.error('parse duration error');
        }
    } else return duration;
});

Handlebars.registerHelper('number_format', function (str) {
    if (str) return new Handlebars.SafeString(str.toLocaleString());
    else return str;
});

Handlebars.registerHelper('increase', function (index) {
    return parseInt(index) + 1;
});

toggleLoadingProgress(false);

function loadData() {
    if (loadDataRequest && loadDataRequest.hasOwnProperty('abort')) loadDataRequest.abort();
    loadDataRequest = $.ajax({
        url: ajaxUrl,
        data: {
            start: startDate.format(serverDateFormat),
            end: endDate.format(serverDateFormat),
            channelId: $('#streamSearch').val() || null,
        },
        success: function (data) {
            let successCount = 0, failCount = 0;
            for (let date in data.viewByDays) {
                if (data.viewByDays[date].successCount) successCount += data.viewByDays[date].successCount;
                if (data.viewByDays[date].failCount) failCount += data.viewByDays[date].failCount;
            }

            $('#successViewCount').text(successCount.toLocaleString());
            let successRatio = 0;
            if (failCount) {
                successRatio = (100 * successCount / (successCount + failCount)).toFixed(2);
            } else {
                if (failCount === 0 && successCount !== 0) {
                    successRatio = 100;
                }
            }
            $('#successViewRatio').text(`${successRatio}%`).siblings('.progress').find(".progress-bar").css('width', `${successRatio}%`);
            drawChart(data);
            if (data.topStreams) {
                $('#stream-rank').html(rankStreamTemplate(data));
            } else {
                $('#stream-rank').html('');
            }

            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
            }).fire({
                icon: 'success',
                title: 'Load data successfully'
            });
        }
    })
}

function drawChart(data) {
    viewChartOptions.labels = Object.keys(data.viewByDays);
    viewChartOptions.series = [
        {
            name: 'Success Views',
            type: 'column',
            data: Object.keys(data.viewByDays).map(function (date) {
                return data.viewByDays[date].successCount
            })
        },
        {
            name: 'Success Rate',
            type: 'line',
            data: Object.keys(data.viewByDays).map(function (date) {
                let successRatio = 0, successCount = data.viewByDays[date].successCount,
                    failCount = data.viewByDays[date].failCount;
                if (failCount) {
                    successRatio = (100 * successCount / (successCount + failCount)).toFixed(2);
                } else {
                    if (failCount === 0 && successCount !== 0) {
                        successRatio = 100;
                    }
                }
                return parseFloat(successRatio);
            })
        }
    ];
    viewChart.updateOptions(viewChartOptions);
}

