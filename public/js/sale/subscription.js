$(document).ready(function () {
    initTableStickyHeader($("#content"));

    $('.toggle-child-row').click(function () {
        $(this)
            .find('i').toggleClass('fa-plus-circle fa-minus-circle text-success text-danger')
            .closest('tr').next('.child-row').toggleClass('d-none')
    });

});

function deleteSubscription(e, url, subscriptionId){
    Swal.fire({
        title: "Xác Nhận Xóa Subscription " + subscriptionId,
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
                        title: 'Đã xóa subscription ' + subscriptionId
                    });
                    $(e).closest('tr').next('.child-row').remove();
                    $(e).closest('tr').remove();
                },
            });
        }
    })
}
