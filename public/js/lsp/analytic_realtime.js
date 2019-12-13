$(document).ready(function () {

    var activeUserChartOptions = {
        colors: ['#28a745'],
        chart: {
            height: 350,
            type: 'line',
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 1000
                }
            },
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            name: "Active Users",
            data: []
        }],
        title: {
            text: 'User Active Chart',
            align: 'center'
        },
        markers: {
            size: 3
        },
        xaxis: {
            type: 'datetime',
        },
        legend: {
            show: false
        },
        tooltip: {
            x: {
                show: true,
                format:"HH:mm:ss"
            }
        }
    };

    var activeUserChart = new ApexCharts(
        document.querySelector("#active-user-chart"),
        activeUserChartOptions
    );

    activeUserChart.render();

    let activeUserRequest = null;
    let activeUserRequestUrl = $('#active-user-chart').attr('data-href');

    function getActiveUserData() {
        if (activeUserRequest) activeUserRequest.abort();
        activeUserRequest = $.ajax({
            url: activeUserRequestUrl,
            method: 'get',
            success: function (activeUserData) {
                activeUserChart.updateSeries([{
                    data: activeUserData
                }])
            }
        });
    }

    getActiveUserData();
    window.setInterval(function () {
        getActiveUserData();
    }, 30000);

    let realTimeCardChartOptions = {
        chart: {
            width: 50,
            height: 35,
            type: 'bar',
            sparkline: {
                enabled: true
            },
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 1000
                }
            },
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '40%',
            },
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return ''
                    }
                }
            },
            marker: {
                show: false
            }
        },
        series: [{
            data: [
                // {x: 1521331200000, y: 78},
                // {x: 1521417600000, y: 44},
                // {x: 1521504000000, y: 70},
                // {x: 1521590400000, y: 13},
                // {x: 1521676800000, y: 25}
            ]
        }],
        markers: {
            size: 0
        },
        legend: {
            show: false
        },
    };
    let cardRealTimeChart = [
        {
            targetElement: $($(".realtime-chart")[0]),
            chart: new ApexCharts($(".realtime-chart")[0], {
                colors: ['#9c27b0'],
                ...realTimeCardChartOptions
            }),
            chartData: [],
        },
        {
            targetElement: $($(".realtime-chart")[1]),
            chart: new ApexCharts($(".realtime-chart")[1], {
                colors: ['#f44336'],
                ...realTimeCardChartOptions
            }),
            chartData: [],
        },
        {
            targetElement: $($(".realtime-chart")[2]),
            chart: new ApexCharts($(".realtime-chart")[2], {
                colors: ['#2196f3'],
                ...realTimeCardChartOptions
            }),
            chartData: [],
        },
        {
            targetElement: $($(".realtime-chart")[3]),
            chart: new ApexCharts($(".realtime-chart")[3], {
                colors: ['#4caf50'],
                ...realTimeCardChartOptions
            }),
            chartData: [],
        },
    ];
    cardRealTimeChart.forEach(element => {
        element.chart.render();
    });

    let streamListTemplate = Handlebars.compile(document.getElementById("stream-list-template").innerHTML);
    Handlebars.registerHelper('calculatePercent', function (deviceCount, playing, buffering, connecting) {
        let percentage = 100 * deviceCount / (playing + buffering + connecting);
        if (percentage && typeof percentage === "number") return percentage.toFixed(0);
        else return 0;
    });
    Handlebars.registerHelper('number_format', function (str) {
        if (str) return new Handlebars.SafeString(str.toLocaleString());
        else return str;
    });
    Handlebars.registerHelper('order_type', function (sortName, sort) {
        if (sort) {
            if (sort.name === sortName) {
                if (sort.type === "desc") {
                    return new Handlebars.SafeString('<i class="fa fa-caret-down mx-2"></i>');
                } else {
                    return new Handlebars.SafeString('<i class="fa fa-caret-up mx-2"></i>');
                }
            }
        }
        return "";
    });

    let sort = "PLAYING", order = "desc";
    $(document).on('click', '.sort', function () {
        sort = $(this).attr('data-sort');
        if ($(this).find('.fa-caret-down').length) order = "asc";
        else order = "desc";
        loadData();
    });

    let loadDataInterval, loadDataAjax;

    function loadData() {
        if (loadDataInterval) clearInterval(loadDataInterval);
        if (loadDataAjax) loadDataAjax.abort();
        loadDataInterval = setInterval(function load() {
            loadDataAjax = $.ajax({
                url: filterUrl,
                method: 'get',
                data: {
                    sort: sort,
                    order: order
                },
                success: function (realTimeData) {
                    $('#channel-card .primary-value').text(realTimeData.channels.length.toLocaleString());
                    let totalView = 0, totaliOS = 0, totalAndroid = 0;
                    realTimeData.channels.forEach(stream => {
                        totalView += stream.PLAYING;
                        totaliOS += stream.IOS;
                        totalAndroid += stream.Android;
                    });
                    // $('#view-card .primary-value').text(totalView);
                    $('#view-card .primary-value').text(realTimeData.totalViews.toLocaleString());
                    $('#ios-card .primary-value').text(totaliOS.toLocaleString());
                    $('#android-card .primary-value').text(totalAndroid.toLocaleString());

                    // update chart data
                    cardRealTimeChart[0].chartData.push(realTimeData.channels.length);
                    cardRealTimeChart[0].chartData.splice(0, cardRealTimeChart[0].chartData.length - 5);
                    cardRealTimeChart[0].chart.updateSeries([{
                        data: cardRealTimeChart[0].chartData
                    }]);

                    // cardRealTimeChart[1].chartData.push(totalView);
                    cardRealTimeChart[1].chartData.push(realTimeData.totalViews);
                    cardRealTimeChart[1].chartData.splice(0, cardRealTimeChart[1].chartData.length - 5);
                    cardRealTimeChart[1].chart.updateSeries([{
                        data: cardRealTimeChart[1].chartData
                    }]);

                    cardRealTimeChart[2].chartData.push(totaliOS);
                    cardRealTimeChart[2].chartData.splice(0, cardRealTimeChart[2].chartData.length - 5);
                    cardRealTimeChart[2].chart.updateSeries([{
                        data: cardRealTimeChart[2].chartData
                    }]);

                    cardRealTimeChart[3].chartData.push(totalAndroid);
                    cardRealTimeChart[3].chartData.splice(0, cardRealTimeChart[3].chartData.length - 5);
                    cardRealTimeChart[3].chart.updateSeries([{
                        data: cardRealTimeChart[3].chartData
                    }]);

                    $('#stream-list').html(streamListTemplate(realTimeData));
                },
            });
            return load;
        }(), 15000);
    }

    loadData();
});
