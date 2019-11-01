$(document).ready(function () {
    initTableStickyHeader($('#content'));

    // copy link khi click nút copy
    new ClipboardJS('.clipboard').on('success', function (e) {
        setTooltip(e.trigger, 'Copied!');
        hideTooltip(e.trigger);
        e.clearSelection();
    }).on('error', function (e) {
        setTooltip(e.trigger, 'Failed!');
        hideTooltip(e.trigger);
    });

    $('.clipboard').tooltip({
        trigger: 'click focus',
        placement: 'bottom'
    });

    function setTooltip(btn, message) {
        $(btn).tooltip('hide')
            .attr('data-original-title', message)
            .tooltip('show');
    }

    // ẩn tooltip sau 1s khi click copy
    function hideTooltip(btn) {
        setTimeout(function () {
            $(btn).tooltip('hide');
        }, 1000);
    }
});

// let deleteConfig = {
//     name: "customer",
//     url: window.location.pathname,
//     key: "userIds"
// };
