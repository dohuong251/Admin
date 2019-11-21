$(document).ready(function () {
    $('#start-date').daterangepicker({
        "singleDatePicker": true,
        // "startDate": moment($('#start-date').val(), "YYYY-MM-DD"),
        "opens": "center",
        "autoUpdateInput": false,
        "drops": "up",
        "autoApply": false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        }
    }).on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format(serverDateFormat));
    });

    $('#expired-date').daterangepicker({
        "singleDatePicker": true,
        "opens": "center",
        "autoUpdateInput": false,
        "drops": "up",
        "autoApply": false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        }
    }).on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format(serverDateFormat));
    });

    if(formActionSuccess){
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
        }).fire({
            icon: 'success',
            title: 'Success!'
        });
    }
});
