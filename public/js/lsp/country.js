let viewMode = 1; // 1: người dùng 2: Kênh 3: thành phố

let startDate = moment(), endDate = moment(), userId, streamId, viewChart, viewChartOptions = {
    markers: {
        size: 4,
        hover: {
            size: 8
        }
    },
    chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        stackType: '100%'
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
    fill: {
        opacity: 1
    },
    tooltip: {
        x: {
            format: "dd/MM"
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
            }
        }
    }]
};

$(document).ready(function () {
    let btnSelectUser = $('#btn-select-user');
    let btnSelectStream = $('#btn-select-stream');
    let btnSelectCountry = $('#btn-select-country');
    let userTable = $('#user-rank');
    let streamTable = $('#stream-rank');
    let countryTable = $('#country-rank');

    btnSelectUser.click(function () {
        viewMode = 1;
        btnSelectUser.removeClass("btn-light")
        btnSelectUser.addClass("btn-primary")
        btnSelectStream.removeClass("btn-primary")
        btnSelectStream.addClass("btn-light")
        btnSelectCountry.removeClass("btn-primary")
        btnSelectCountry.addClass("btn-light")

        userTable.removeClass("d-none")
        streamTable.addClass("d-none")
        countryTable.addClass("d-none")

    })

    btnSelectStream.click(function () {
        viewMode = 2;
        btnSelectUser.removeClass("btn-primary")
        btnSelectUser.addClass("btn-light")
        btnSelectStream.removeClass("btn-light")
        btnSelectStream.addClass("btn-primary")
        btnSelectCountry.removeClass("btn-primary")
        btnSelectCountry.addClass("btn-light")

        userTable.addClass("d-none")
        streamTable.removeClass("d-none")
        countryTable.addClass("d-none")
    })

    btnSelectCountry.click(function () {
        viewMode = 3;
        btnSelectUser.removeClass("btn-primary")
        btnSelectUser.addClass("btn-light")
        btnSelectStream.removeClass("btn-primary")
        btnSelectStream.addClass("btn-light")
        btnSelectCountry.removeClass("btn-light")
        btnSelectCountry.addClass("btn-primary")

        userTable.addClass("d-none")
        streamTable.addClass("d-none")
        countryTable.removeClass("d-none")
    })

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
            $(this).val(startDate.format(locacleDateFormat) + ' - ' + endDate.format(locacleDateFormat));
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
    rankUserTemplate = Handlebars.compile(document.getElementById("user-rank-template").innerHTML),
    rankCountryTemplate = Handlebars.compile(document.getElementById("country-rank-template").innerHTML);

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
            viewMode:viewMode,
            country:$('#countrySelect').val()
        },
        success: function (data) {
            console.log("response")
            console.log(data)
            drawChart(data);

            let userTable = $('#user-rank');
            let streamTable = $('#stream-rank');
            let countryTable = $('#country-rank');
            if(viewMode === 1){
                userTable.removeClass("d-none")
                streamTable.addClass("d-none")
                countryTable.addClass("d-none")
            }else if(viewMode === 2){
                userTable.addClass("d-none")
                streamTable.removeClass("d-none")
                countryTable.addClass("d-none")
            }else {
                userTable.addClass("d-none")
                streamTable.addClass("d-none")
                countryTable.removeClass("d-none")
            }

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

            if(data.topCountries){
                $('#country-rank').html(rankCountryTemplate(data));
            }else $('#country-rank').html('');

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
    if(!data || !data.viewByDays || data.allCountry.length === 0){
        viewChart.clear();
        return;
    } else{
        viewChartOptions.xaxis = {categories:Object.keys(data.viewByDays)};
        let series = data.allCountry.map(function (item) {
            return {
                name:item,
                data:Object.keys(data.viewByDays).map(function (date) {
                    return data.viewByDays[date][item]
                })
            }
        })
        viewChartOptions.series = series?series:[];
    }

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

