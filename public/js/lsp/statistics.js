let startDate = moment(), endDate = moment(), userId, streamId, viewChart, viewChartOptions = {
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
        // "showWeekNumbers": true,
        "linkedCalendars": false,
        ranges: {
            'Hôm Nay': [moment(), moment()],
            'Hôm Qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tuần Này': [moment().startOf('week'), moment().endOf('week')],
            'Tháng Này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng Trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            // 'Tất cả': [moment(0), moment()],
        },
        locale: {
            cancelLabel: 'Clear'
        },
        "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "startDate": moment(),
        "endDate": moment(),
        // "opens": "center",
        maxDate: moment(),
    })
        .on('apply.daterangepicker', function (ev, picker) {
            startDate = picker ? picker.startDate : startDate;
            endDate = picker ? picker.endDate : endDate;
            $(this).val(startDate.format(localeDateFormat) + ' - ' + endDate.format(localeDateFormat));
        })
        .on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        })
        .trigger('apply.daterangepicker');

    $('#userSearch').select2({
        width: '100%',
        placeholder: "Tìm theo tên thành viên",
        allowClear: true,
        ajax: {
            cache: true,
            delay: 500,
            url: ajaxSearchUrl,
            data: function (params) {
                return {
                    query: params.term,
                    type: 0,
                    page: params.page || 1
                };
            },
            dataType: 'json',
        }
    }).on('select2:select select2:unselect select2:clear', function () {
        initStreamSelect();
    });

    initStreamSelect();

    function initStreamSelect() {
        $('#streamSearch').select2({
            width: '100%',
            placeholder: "Tìm theo tên stream",
            allowClear: true,
            ajax: {
                cache: true,
                delay: 500,
                url: ajaxSearchUrl,
                data: function (params) {
                    if ($('#userSearch').val()) {
                        return {
                            query: params.term,
                            type: 1,
                            userId: $('#userSearch').val(),
                            page: params.page || 1
                        };
                    } else {
                        return {
                            query: params.term,
                            type: 1,
                            page: params.page || 1
                        };
                    }
                },
                dataType: 'json',
            }
        });
    }

    /**
     * nếu số lượng stream của 1 user nhiều (>50 - MAX_STREAM_DISPLAY) hiện thêm khi cuộn xuống cuối
     */
    $(window).on('scroll', function () {
        if ($(this).scrollTop() >= $('#stream-rank').offset().top - ($(window).height() - $('#stream-rank').height())) {
            $($('#stream-rank').find('tbody tr.d-none').splice(0, MAX_STREAM_DISPLAY)).removeClass('d-none')
        }
    });
});

let loadDataRequest, MAX_STREAM_DISPLAY = 50,
    rankStreamTemplate = Handlebars.compile(document.getElementById("stream-rank-template").innerHTML),
    rankUserTemplate = Handlebars.compile(document.getElementById("user-rank-template").innerHTML);

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

Handlebars.registerHelper('reach_limit', function (index) {
    return (parseInt(index) + 1) > MAX_STREAM_DISPLAY;
});

toggleLoadingProgress(false);

function loadData() {
    if (loadDataRequest && loadDataRequest.hasOwnProperty('abort')) loadDataRequest.abort();
    loadDataRequest = $.ajax({
        url: ajaxUrl,
        data: {
            start: startDate.format(serverDateFormat),
            end: endDate.format(serverDateFormat),
            userId: $('#userSearch').val() || null,
            streamId: $('#streamSearch').val() || null,
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
            if (data.topUsers) {
                $('#user-rank').html(rankUserTemplate(data));
            } else {
                $('#user-rank').html('');
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
        // {
        //     name: 'Published',
        //     data: publishedData.map(function (v) {
        //         return {
        //             x: v.Date,
        //             y: v.Total
        //         }
        //     })
        // }
    ];

    // viewChartOptions.legend = {
    //     formatter: function (seriesName, opts) {
    //         if (opts.seriesIndex === 0) {
    //             return [seriesName, ": ", _.sum(_.map(lastOnlineData, 'Total')).toLocaleString()].join("");
    //         } else {
    //             return [seriesName, ": ", _.sum(_.map(publishedData, 'Total')).toLocaleString()].join("");
    //         }
    //     }
    // };
    viewChart.updateOptions(viewChartOptions);
}

