$(document).ready(function () {
    $('.chat-sidebar-toggle').click(e => {
        // toggle button mobile screen
        $('#chat-sidebar').toggleClass('open');
        e.preventDefault();
    });

    // select user to send new message in modal
    $('.select2-multiple').select2({
        closeOnSelect: false,
        placeholder: "Chọn người nhận",
        templateResult: function (optionRow) {
            if (!optionRow.id) {
                return optionRow.text;
            }
            let user = conversationUsers.find(function (user) {
                return user.UserId == optionRow.id;
            });
            if (!user) return optionRow.text;
            return $(`<div class="peers ai-c">
                                   <div class="peer mR-20 w-3r h-3r">
                                        <img src="${user.Avatar || '/images/icon/avatar.png'}" alt="" class="user-avatar w-3r h-3r bdrs-50p ${user.Avatar ? '' : 'bg-secondary'}" onerror="onLoadAvatarError(this)">
                                    </div>
                                    <div class="peer">
                                        <h6 class="lh-1 mB-0">
                                            ${optionRow.text}
                                        </h6>
                                        <i class="fsz-sm lh-1">${user.FacebookId || user.Email}</i>
                                    </div>
                                </div>`);
        }
    });

    $('.modal').on('shown.bs.modal', function (e) {
        $('.select2-multiple').trigger('change');
    });

    // ẩn các avatar liên tiếp trong phần tin nhắn, comment code để thấy thay đổi
    $('.message-container').each(function () {
        if (($(this).next().hasClass('message-host') && $(this).hasClass('message-guest')) || ($(this).next().hasClass('message-guest') && $(this).hasClass('message-host'))) {
            $(this).find('.user-avatar').css('visibility', 'visible');
        }
    });

    // xóa bỏ contact nếu không có tin nhắn (xóa bỏ chính user hiện tại nếu không có tin nhắn tự gửi cho bản thân)
    $('.message-content > .scrollable').each(function () {
        if (!$(this).text().trim().length) {
            $(`[data-toggle="#${$(this).parent().attr('id')}"]`).remove();
            $(this).parent().remove();
        }
    });

    // ẩn, hiện tin nhắn khi click vào contact bên trái
    $('.messenger').click(function () {
        $('.message-content').addClass('d-none');
        $(this).addClass('active').siblings('.messenger').removeClass('active');
        $($(this).attr('data-toggle')).removeClass('d-none');
    }).first().click();

    $('#mainContent > div').addClass('px-0');

    // filter contact khi gõ vào ô search
    $('input[name=chatSearch]').keyup(function () {
        let searchVal = $(this).val().trim().toLowerCase();
        $('.messenger').each(function () {
            // tìm chuỗi nhập vào trong thông tin contact (tên, email, facebookid), ẩn contact không khớp
            if ($(this).find('.information').get().find(function (e) {
                return $(e).text().trim().toLowerCase().includes(searchVal);
            })) {
                $(this).removeClass('d-none').addClass('peers');
            } else {
                $(this).addClass('d-none').removeClass('peers');
            }
        });
    });

    // admin gửi tin nhắn cho user bằng ô input trong phần tin nhắn
    $('.submit-message').ajaxForm({
        beforeSubmit: function (formData, jqForm, options) {
            let randomId = '_' + Math.random().toString(36).substr(2, 9);
            // append new message with loading icon(.lds-css)
            jqForm.parents('.message-content').find('.message-container').last().after(`<div id="${randomId}" class="peers fxw-nw ai-fe message-container message-host"><div class="peer ord-1 mL-20"><img class="user-avatar w-2r bdrs-50p" src="${adminAvatar}" alt=""></div><div class="peer peer-greed ord-0"><div class="layers ai-fe gapY-10"><div class="layer message-box"><div class="peers fxw-nw ai-c pY-3 pX-10  bdrs-2 lh-3/2" data-toggle="tooltip" data-placement="right" title="" data-original-title="${moment().format('HH:mm DD/MM/YYYY')}"><div class="lds-css ng-scope"><div class="lds-spinner" style=""><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div><span class="text-break">${jqForm.find('input[name=Message]').val()}</span></div></div></div></div></div>`);
            jqForm.clearForm();
            // id of new message div
            formData.push({name: "ID", value: randomId}, {name: "XHR", value: true});
            $('.message-container').each(function () {
                if (($(this).next().hasClass('message-host') && $(this).hasClass('message-guest')) || ($(this).next().hasClass('message-guest') && $(this).hasClass('message-host'))) {
                    $(this).find('.user-avatar').css('visibility', 'visible');
                }
            });
        },
        success: function (response, statusText, xhr, $form) {
            // remove loading icon, append delete icon
            let spinner = $(`#${response.ID}`).find('.lds-css');
            spinner.parent()
                .append(`<i class="fa fa-trash text-danger fsz-xs ml-2 cur-p delete-message" data-id="${response.MessageId}"></i>`);
            spinner.remove();
        }
    });

    // xóa tin nhắn
    $('body').on('click','.delete-message', function () {
        Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger mr-3',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteUrl,
                    type: "DELETE",
                    data: {
                        Id: $(this).attr('data-id')
                    },
                    success: () => {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        }).fire(
                            'Deleted!',
                            'Message has been deleted.',
                            'success'
                        ).then(() => {
                            $(this).parents('.message-container').remove();
                        })
                    },
                    error: () => {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        }).fire(
                            'Something went wrong!',
                            'Message has not been deleted.',
                            'error'
                        )
                    }
                });

            }
        })
    })
});
