$(document).ready(function () {
    // $('button').click(function () {
    //     window.location.href = $(this).attr('href');
    // });
    $('.editProfile').click(function () {

        $('.card-title').addClass('d-none');
        $('.edtName').removeClass('d-none');
        $('.editProfile').addClass('d-none');

        $('.email').addClass('d-none');
        $('.edt-email').removeClass('d-none');

        $('.facebook').addClass('d-none');
        $('.edt-fb').removeClass('d-none');

        $('.role').addClass('d-none');

        $('.phone').addClass('d-none');
        $('.edt-phone').removeClass('d-none');

        $('.birthday').addClass('d-none');
        $('.edt-birthday').removeClass('d-none');

        $('#role').on('change', function() {
        });

    });

    $('.btn-delete').click(function () {
        $('.card-title').removeClass('d-none');
        $('.edtName').addClass('d-none');
        $('.editProfile').removeClass('d-none');

        $('.email').removeClass('d-none');
        $('.edt-email').addClass('d-none');

        $('.facebook').removeClass('d-none');
        $('.edt-fb').addClass('d-none');

        $('.role').removeClass('d-none');

        $('.phone').removeClass('d-none');
        $('.edt-phone').addClass('d-none');

        $('.birthday').removeClass('d-none');
        $('.edt-birthday').addClass('d-none');
    });

    // $('.btn-edit').click(function () {
    //     let form = $('#editForm');
    //
    //     let phone= form.find("input[name='phone']").val();
    //     console.log(phone);
    //     $.ajax({
    //         type: "PUT",
    //         url: form.attr('action') || window.location.pathname,
    //         data: form.serialize(),
    //
    //         success: function (response) {
    //             try{
    //                 response = JSON.parse(response);
    //             }catch (e) {
    //
    //
    //             }
    //
    //         }
    //
    //
    //     });
    // });

    $('.btnDelete').click(function () {

    });



});
