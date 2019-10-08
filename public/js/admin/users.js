$(document).ready(function () {
    $('table tbody tr').click(function (event) {
        if (event.target.type !== 'checkbox' && !$(event.target).is('a')) {
            window.location.href = $(this).find('a').attr('href');
        }
    });

});

let deleteConfig = {
    name: "customer",
    url: window.location.pathname,
    key: "userIds"
};
