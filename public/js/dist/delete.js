$(document).ready(function () {
    let deleteBtn = $('.delete-btn');

    // loadding effect on delete button
    let deleteLadda = Ladda.create(document.querySelector('.delete-btn'));

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
            deleteBtn.addClass('fadeInUp').removeClass('fadeOutDown').find('.ladda-label').text(` Xóa ${$('.select-row:checked').length} ${deleteOptions.recordName || "bản ghi"}`);
        } else {
            deleteBtn.addClass('fadeOutDown').removeClass('fadeInUp');
        }
    }

    $('#delete-btn').click(function () {
        Swal.fire({
            title: 'Xác Nhận',
            text: `Xác nhận ${$(this).text().toLowerCase()}`,
            type: 'warning',
            confirmButtonClass: 'btn btn-danger mr-3',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: function () {
                return new Promise(resolve => {
                    // Swal.showLoading();
                    deleteLadda.start();
                    // xác nhận xóa tin nhắn
                    $.ajax({
                        url: deleteOptions.deleteUrl,
                        type: "DELETE",
                        data: {
                            Id: $('.select-row:checked').map(function () {
                                return $(this).attr('data-id');
                            }).get()
                        },
                        success: (data) => {
                            // xóa thành công
                            deleteLadda.stop();
                            resolve({
                                success: true,
                                data: data
                            });
                        },
                        error: () => {
                            // xóa thất bại
                            deleteLadda.stop();
                            resolve({
                                success: false,
                            });
                        },
                    });
                });
            }
        }).then(function (response) {
            if (response.value) {
                if (response.value.success) {
                    //success
                    Swal.fire({
                        title: 'Đã Xóa',
                        text: `Đã xóa ${response.value.data} ${deleteOptions.recordName}`,
                        type: 'success',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                    }).then(() => {
                        $('.select-row:checked').parents('tr').remove();
                        toggleDeleteBtn(false);
                        if (typeof dataTable !== "undefined" && dataTable) {
                            dataTable.DataTable().ajax.reload();
                        }
                    });
                } else {
                    // fail
                    Swal.fire({
                        title: 'Lỗi!',
                        text: `Có lỗi xảy ra`,
                        type: 'error',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                    });
                }
            }
        });
    });
});
