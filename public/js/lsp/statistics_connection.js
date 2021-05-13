$(document).ready(function () {
    $(".filter-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $(this).serializeArray(),
            success: function (response) {

            }
        });
    });

    let connectionDailyChart = new ApexCharts(
        document.querySelector(".connection-daily-chart"),
        {
            width: '100%',
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
                    text: 'Connections',
                },
                labels: {
                    formatter: value => {
                        if (value) return `${value.toLocaleString()}`;
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
        }
    );
    connectionDailyChart.render();

    let deviceDailyChart = new ApexCharts(
        document.querySelector(".device-daily-chart"),
        {
            width: '100%',
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
                    text: 'Connections',
                },
                labels: {
                    formatter: value => {
                        if (value) return `${value.toLocaleString()}`;
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
        }
    );
    deviceDailyChart.render();

    let pieTotalChart = new ApexCharts(
        document.querySelector(".pie-total-chart"),
        {
            width: '100%',
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
                    text: 'Connections',
                },
                labels: {
                    formatter: value => {
                        if (value) return `${value.toLocaleString()}`;
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
        }
    );
    pieTotalChart.render();

    $("[name=Version]").select2({
        ajax: {
            url: function () {
                return $(this).attr("data-url")
            },
            data: function (params) {
                return {
                    // type: "Version",
                    search: params.term,
                    id_application: $(this).closest("form").find("[name=id_application]").val(),
                    page: params.page || 1
                };
            }
        },
        placeholder: "Chọn Version",
    });

    $("[name=id_application]").select2({
        placeholder: "Chọn Application",
    }).on("select2:select", function (e) {
        // $(this).closest("form").find('[name="Version"]').find("option:not(:disabled)").remove();
        $(this).closest("form").find('[name="Version"]').empty().val(null).trigger("change");
    });

    $('[name="date-range"]').daterangepicker({
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
        // "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "startDate": moment(),
        "endDate": moment(),
        // "opens": "center",
        maxDate: moment(),
    }, function (startDate, endDate) {
        $(this.element).siblings("[name=date-range-start]").val(startDate.valueOf());
        $(this.element).siblings("[name=date-range-end]").val(endDate.valueOf());
    })
        .on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        })
        .siblings("[name=date-range-start]").val(moment().startOf("day").valueOf())
        .siblings("[name=date-range-end]").val(moment().endOf("day").valueOf());
});
