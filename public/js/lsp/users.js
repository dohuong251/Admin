$(document).ready(function () {
    $('table tbody tr').click(function (event) {
        if ($(event.target).prop("tagName").toLowerCase() === 'th') {
            let checkbox = $(this).find('input[type=checkbox]');
            checkbox.prop('checked', !checkbox.is(':checked'));
            return;
        }

        if (event.target.type !== 'checkbox' && !$(event.target).is('a')) {
            window.location.href = $(this).attr('data-href');
        }
    });

    let contentTable = $('#content');
    contentTable.stickyTableHeaders({
        fixedOffset: $('.header'),
        // scrollableArea: $('.full-container')
    });

    $("#list").scroll(function () {
        $(window).trigger('resize.stickyTableHeaders');
    })

});

// let deleteConfig = {
//     name: "customer",
//     url: window.location.pathname,
//     key: "userIds"
// };
