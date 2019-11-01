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
            'Test': [moment('7/1/2017'), moment('9/1/2017')],
        },
        // "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "startDate": moment(),
        "endDate": moment(),
        "opens": "center",
        maxDate: moment(),
    }).on('apply.daterangepicker', function (ev, picker) {
        if (!picker) {
            startDate = moment();
            endDate = moment();
        } else {
            startDate = picker.startDate;
            endDate = picker.endDate;
        }
        $(this).val(startDate.format(locacleDateFormat) + ' - ' + endDate.format(locacleDateFormat));
        $.get($(this).attr('data-url'), {
            startDate: startDate.format(serverDateFormat),
            endDate: endDate.format(serverDateFormat)
        }, function (chartData) {
            console.log(chartData);
            if (Object.keys(chartData).length === 0) return;
            if (!chartData.LastOnline || !chartData.Published) return;
            let lastOnlineData = chartData.LastOnline, publishedData = chartData.Published, maxDate, minDate,
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

            options.series = [
                {
                    name: 'Last Online',
                    data: lastOnlineData.map(function (v) {
                        return {
                            x: v.Date,
                            y: v.Total
                        }
                    })
                },
                {
                    name: 'Published',
                    data: publishedData.map(function (v) {
                        return {
                            x: v.Date,
                            y: v.Total
                        }
                    })
                }
            ];

            options.legend = {
                formatter: function (seriesName, opts) {
                    if (opts.seriesIndex === 0) {
                        return [seriesName, ": ", _.sum(_.map(lastOnlineData, 'Total')).toLocaleString()].join("");
                    } else {
                        return [seriesName, ": ", _.sum(_.map(publishedData, 'Total')).toLocaleString()].join("");
                    }
                }
            };
            chart.updateOptions(options);
        })
    });
    inputDatePicker.trigger("apply.daterangepicker");

    let options = {
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

    let chart = new ApexCharts(
        document.querySelector("#lsp-chart"),
        options
    );

    chart.render();
});
