$(document).ready(function () {
    let inputDatePicker = $('#lsp-date-picker'), startDate, endDate;
    inputDatePicker.daterangepicker({
        // "showWeekNumbers": true,
        "linkedCalendars": false,
        ranges: {
            'Hôm Nay': [moment(), moment()],
            'Hôm Qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tuần Này': [moment().startOf('week'), moment().endOf('week')],
            'Tháng Này': [moment().startOf('month'), moment().endOf('month')],
            'Năm Nay': [moment().startOf('year'), moment()],
            'Năm Trước': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            // 'Tất cả': [moment(0), moment()],
        },
        // "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "startDate": moment().startOf('month'),
        "endDate": moment().endOf('month'),
        "opens": "center",
        maxDate: moment(),
    }).on('apply.daterangepicker', function (ev, picker) {
        if (!picker) {
            startDate = moment().startOf('month');
            endDate = moment().endOf('month');
        } else {
            startDate = picker.startDate;
            endDate = picker.endDate;
        }
        $(this).val(startDate.format(locacleDateFormat) + ' - ' + endDate.format(locacleDateFormat));
        $.get($(this).attr('data-url'), {
            startDate: startDate.format(serverDateFormat),
            endDate: endDate.format(serverDateFormat)
        }, function (data) {
            // update stream chart
            let lspStreamChartData = data.LspStream;
            if (Object.keys(lspStreamChartData).length === 0) return;
            if (!lspStreamChartData.LastOnline || !lspStreamChartData.Published) return;
            let lastOnlineData = lspStreamChartData.LastOnline, publishedData = lspStreamChartData.Published, maxDate,
                minDate,
                dateRange = [];
            minDate = moment.min(lastOnlineData[0] ? parseServerDate(lastOnlineData[0].Date) : moment(), publishedData[0] ? parseServerDate(publishedData[0].Date) : moment());
            maxDate = moment.max(lastOnlineData[lastOnlineData.length - 1] ? parseServerDate(lastOnlineData[lastOnlineData.length - 1].Date) : moment(0), publishedData[publishedData.length - 1] ? parseServerDate(publishedData[publishedData.length - 1].Date) : moment(0));
            while (minDate.isBefore(maxDate)) {
                dateRange.push({
                    Date: minDate.format(serverDateFormat),
                    Total: 0
                });
                minDate.add(1, 'day');
            }
            lastOnlineData = _.unionBy(lastOnlineData, dateRange, "Date");
            publishedData = _.unionBy(publishedData, dateRange, "Date");

            streamChartOptions.series = [
                {
                    name: 'Last Online Stream',
                    data: lastOnlineData.map(function (v) {
                        return {
                            x: v.Date,
                            y: v.Total
                        }
                    })
                },
                {
                    name: 'Published Stream',
                    data: publishedData.map(function (v) {
                        return {
                            x: v.Date,
                            y: v.Total
                        }
                    })
                }
            ];

            streamChartOptions.legend = {
                formatter: function (seriesName, opts) {
                    if (opts.seriesIndex === 0) {
                        return [seriesName, ": ", _.sum(_.map(lastOnlineData, 'Total')).toLocaleString()].join("");
                    } else {
                        return [seriesName, ": ", _.sum(_.map(publishedData, 'Total')).toLocaleString()].join("");
                    }
                }
            };
            streamChart.updateOptions(streamChartOptions);

            // update order chart
        })
    });
    setTimeout(function () {
        inputDatePicker.trigger("apply.daterangepicker")
    }, 300);

    let streamChartOptions = {
        type: 'bar',
        width: '50%',
        chart: {
            height: 350,
            type: 'bar',
        },
        // plotOptions: {
        //     bar: {
        //         // horizontal: false,
        //         // columnWidth: '55%',
        //         // endingShape: 'rounded'
        //     },
        // },
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
        // yaxis: {
        //     title: {
        //         // text: '$ (thousands)'
        //     }
        // },
        fill: {
            opacity: 1
        },
        tooltip: {
            x: {
                format: "dd/MM"
            }
        }
    };
    let streamChart = new ApexCharts(
        document.querySelector("#lsp-chart"),
        streamChartOptions
    );
    streamChart.render();

    let donutChartOption = {
        chart: {
            type: 'donut',
        },
        tooltip: {
            enabled: true,
            y: {
                formatter: function (val) {
                    if (val) return val.toLocaleString();
                    return val;
                },
            }
        },
        legend: {
            formatter: function (seriesName, opts) {
                return [seriesName, ": ", opts.w.config.series[opts.seriesIndex].toLocaleString()].join("");
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            showAlways: true,
                        }
                    }

                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                // chart: {
                //     width: 200
                // },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: false,
                                total: {
                                    show: false,
                                }
                            }

                        }
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    let lspOrderChartOption = {
        title: {
            text:"Live Stream Player Orders",
            align:'center'
        },
        series: _.map(lspOrder, "Total"),
        labels: _.map(lspOrder, function (purchaseType) {
            switch (purchaseType.PurchaseMethod) {
                case 0:
                    return "Key";
                case 1:
                    return "Paymall";
                case 2:
                    return "Phone Card";
                case 3:
                    return "Amazon";
                case 4:
                    return "Apple";
                case 5:
                    return "Paypal";
                case 6:
                    return "License Key";
                case 7:
                    return "MDC Admin";
                default:
                    purchaseType.PurchaseMethod;
            }
        }),
        ...donutChartOption
    };
    let lspOrderChart = new ApexCharts(
        document.querySelector("#lsp-order-chart"),
        lspOrderChartOption
    );
    lspOrderChart.render();

    let ustvOrderChartOption = {
        title: {
            text:"USTV Orders",
            align:'center'
        },
        series: _.map(ustvOrder, "Total"),
        labels: _.map(ustvOrder, function (purchaseType) {
            switch (purchaseType.PurchaseMethod) {
                case 0:
                    return "Key";
                case 1:
                    return "Paymall";
                case 2:
                    return "Phone Card";
                case 3:
                    return "Amazon";
                case 4:
                    return "Apple";
                case 5:
                    return "Paypal";
                case 6:
                    return "License Key";
                case 7:
                    return "MDC Admin";
                default:
                    purchaseType.PurchaseMethod;
            }
        }),
        ...donutChartOption
    };
    let ustvOrderChart = new ApexCharts(
        document.querySelector("#ustv-order-chart"),
        ustvOrderChartOption
    );
    ustvOrderChart.render();
});
