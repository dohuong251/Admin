$(document).ready(function () {
    let confirm = false;
    $('body').on('submit', '#stop-form, #start-form', function (e) {
        if(!confirm){
            e.preventDefault();
            Swal.fire({
                title: $(this).attr('id') === "start-form" ? "Xác nhận bắt đầu chương trình giảm giá" : "Xác nhận hủy bỏ chương trình giảm giá hiện tại",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác Nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.value) {
                    confirm = true;
                    $(this).submit();
                } else {
                    confirm = false;
                }
            });
        }
    })
});
