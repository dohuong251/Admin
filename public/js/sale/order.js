$(document).ready(function () {
    initTableStickyHeader($('#content'));

    $('.date-picker').daterangepicker({
        "linkedCalendars": false,
        ranges: {
            'Hôm Nay': [moment(), moment()],
            'Hôm Qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tuần Này': [moment().startOf('week'), moment().endOf('week')],
            'Tháng Này': [moment().startOf('month'), moment().endOf('month')],
            'Năm Nay': [moment().startOf('year'), moment()],
            'Năm Trước': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        },
        locale: {
            cancelLabel: 'Clear'
        },
        "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "opens": "center",
        maxDate: moment(),
    }).on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate;
        endDate = picker.endDate;
        $(this).val(startDate.format(locacleDateFormat) + ' - ' + endDate.format(locacleDateFormat))
            .siblings("[name=start]").val(startDate.format(serverDateFormat))
            .siblings("[name=end]").val(endDate.format(serverDateFormat));
    }).on('cancel.daterangepicker', function () {
        $(this).val(null)
            .siblings("[name=start]").val(null)
            .siblings("[name=end]").val(null);
    });
});
