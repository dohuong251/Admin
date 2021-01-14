$(document).ready(function () {
    initTableStickyHeader($('#content'));

    let sendNewLicenseKeyForm = Handlebars.compile(document.getElementById("send-new-license-key-form").innerHTML),
        resendLicenseKeyForm = Handlebars.compile(document.getElementById("resend-license-key-form").innerHTML);
    $('#sendLicenseModal').on('show.bs.modal', function (e) {
        if ($(e.relatedTarget).attr('data-resend')) {
            // resend form
            $(this).find('.modal-body').html(resendLicenseKeyForm({
                apps: apps,
                appid: $(e.relatedTarget).attr('data-applicationid'),
                email: $(e.relatedTarget).attr('data-email'),
                licenseKey: $(e.relatedTarget).attr('data-license'),

            }));
        } else {
            // send new key form
            $(this).find('.modal-body').html(sendNewLicenseKeyForm({
                apps: apps,
            }));
        }
    });
});

Handlebars.registerHelper('ifEqual', function (value1, value2, options) {
    if (value1 == value2) {
        return options.fn(this);
    }
    return options.inverse(this);
});

function deleteLicenseKey(e, url, licenseKey) {
    Swal.fire({
        title: "Xác Nhận Xóa Key " + licenseKey,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xác Nhận',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                method: 'delete',
                success: function (response) {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).fire({
                        icon: 'success',
                        title: 'Đã xóa key ' + licenseKey
                    });
                    $(e).closest('tr').remove();
                },
            });
        }
    })
}
