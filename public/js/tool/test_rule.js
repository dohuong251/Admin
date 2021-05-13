$(document).ready(function () {
    let updateRuleRequest = null;
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    }).on('click', '#update-rule', function () {
        if (!window.editor) return;

        Swal.fire({
            text: "Đồng bộ luật với config hiện tại ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xác Nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.value) {
                updateRuleRequest = $.ajax({
                    url: $(this).attr('data-url'),
                    type: "PUT",
                    contentType: "application/json",
                    data: JSON.stringify({
                        rule: JSON.stringify(editor.get()),
                    }),
                    beforeSend: function () {
                        if (updateRuleRequest != null) {
                            updateRuleRequest.abort();
                        }
                    },
                    success: (data) => {
                        if (data && data.result) {
                            Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            }).fire({
                                icon: 'success',
                                title: 'Cập Nhật Luật Thành Công!'
                            });
                        } else {
                            Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            }).fire({
                                icon: 'error',
                                title: 'Cập Nhật Luật Thất Bại!'
                            });
                        }
                    },
                    error: (e) => {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        }).fire({
                            icon: 'error',
                            title: 'Cập Nhật Luật Thất Bại!'
                        });
                    }
                });
            }
        });
    });

    let ruleFormRequest;
    $('#rule-form').submit(function (e) {
        e.preventDefault();
        if (!window.editor) return;
        let rules = JSON.stringify(editor.get());

        if (ruleFormRequest) ruleFormRequest.abort();
        ruleFormRequest = $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            contentType: "application/json",
            data: JSON.stringify({
                url: $('#url').val(),
                rules,
            }),
            success: (data) => {
                data = JSON.parse(data);
                $('#result').html(testRuleResultTemplate(data));

                $("html, body").animate({scrollTop: $("#result").offset().top - $('.header-container').height() - 10}, 1000);

                new ClipboardJS('#result-link').on('success', function (e) {
                    $(e.trigger).tooltip('hide')
                        .attr('data-original-title', "Đã sao chép!")
                        .tooltip('show');
                }).on('error', function (e) {
                    $(e.trigger).tooltip('hide')
                        .attr('data-original-title', "Sao chép lỗi!")
                        .tooltip('show');
                });
                $('#result-link').mouseleave(function () {
                    $(this).attr('data-original-title', "Nhấp để sao chép");
                });
            },
        });
    });
});

let testRuleResultTemplate = Handlebars.compile(document.getElementById("result-template").innerHTML);

