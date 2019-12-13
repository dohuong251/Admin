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

    $(document).on('click', '.delete-version', function (e) {
        if (!$(this).attr("data-href")) return;
        Swal.fire({
            text: `Xác nhận xóa ${$(this).siblings('a').text().toLowerCase()} ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xác Nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: $(this).attr("data-href"),
                    type: "DELETE",
                    beforeSend: () => {
                        $(this).attr('disabled', true).siblings('a').attr('onclick', 'return false;');
                    },
                    success: (data) => {
                        // xóa thành công
                        $(this).closest('.app-version').remove();
                        _.remove(apps, {
                            app_version_id: Number.parseInt($(this).attr("data-version-id"))
                        });
                    },
                    error: (xhr) => {
                        // xóa thất bại
                        $(this).attr('disabled', false).siblings('a').removeAttr('onclick');
                    }
                })
            }
        });
    })
});
