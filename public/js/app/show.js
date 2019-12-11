$(document).ready(function () {
    $('.app-card').hover(function () {
        $(this).addClass('shadow-lg');
    }, function () {
        $(this).removeClass('shadow-lg');
    });

    let editModalTemplate = Handlebars.compile(document.getElementById("edit-modal-content").innerHTML);
    $('#edit-modal').on('show.bs.modal', function (e) {
        let platformId = $(e.relatedTarget).attr("data-platform");
        if (platformId && _.filter(apps, function (v) {
            return v.platform_id == platformId
        }).length) {
            $(e.target).find('.modal-content').html(editModalTemplate({
                data: _.filter(apps, function (v) {
                    return v.platform_id == platformId
                })
            }));
        } else {
            e.stopPropagation();
        }
    });
});
