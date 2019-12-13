$(document).ready(function () {
    $('input[name=icon_url],input[name=ads_image]').change(function () {
        $(this).siblings('label')
            .html(`${$(this).siblings('label').text()} <img data-toggle="tooltip" data-html="true" data-original-title="<img width='192' src='${$(this).val()}'>" height="21px" src="${$(this).val()}">`)
    }).trigger('change');

    $(document).tooltip({
        selector: '[data-toggle="tooltip"]'
    }).on('click', '.btn-add', function () {
        $(this).siblings('.form-group').append(`<input type="text" class="form-control " name="Image[]" value="">`)
    })
});
