$(document).ready(function () {
    // nếu chọn selectall: tự chọn các hết các ô checkbox
    $('#selectAll').click(function () {
        let state = $('#selectAll').prop("checked");
        let checkbox = $('.select-row');
        checkbox.prop("checked", state);
        toggleDeleteBtn(state)
    });

    // sự kiện chọn / bỏ chọn checkbox trong bảng
    $('body').on('click', '.select-row', function () {
        let checkedRow = $('.select-row:checked');
        let isSellectAll = checkedRow.length === $('.select-row').length;
        let selectAll = $('#selectAll');

        if (checkedRow.length) {
            toggleDeleteBtn(true);
        } else toggleDeleteBtn(false);

        if ((isSellectAll && !selectAll.prop("checked")) || (!isSellectAll && selectAll.prop("checked"))) {
            selectAll.prop("checked", isSellectAll);
        }
    });

    /**
     *
     * @param show: true - hiện nút xóa, false - ẩn nút xúa
     */
    function toggleDeleteBtn(show) {
        if (show) {
            $('#delete-btn').addClass('fadeInUp').removeClass('fadeOutDown').find('.ladda-label').text(` Xóa ${$('.select-row:checked').length} bản ghi`);
        } else {
            $('#delete-btn').addClass('fadeOutDown').removeClass('fadeInUp');
        }
    }
});
