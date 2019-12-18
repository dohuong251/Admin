$(document).ready(function () {
    initTableStickyHeader($('#content'));
});

function deleteOrder(e, url, orderId) {
    Swal.fire({
        title: "Xác Nhận Xóa Order " + orderId,
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
                        title: 'Đã xóa order ' + orderId
                    });
                    $(e).closest('tr').remove();
                },
            });
        }
    })
}
