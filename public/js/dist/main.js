$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let locacleDateFormat = "DD/MM/YYYY";
let serverDateFormat = "YYYY-MM-DD";
