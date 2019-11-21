$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            toggleLoadingProgress(true);
            if (window.Swal && Swal.isVisible()) Swal.close();
        },
        error: function (xhr, status, error) {
            if (status !== 'abort') {
                console.error(error);
                if (window.Swal) {
                    let message = "";
                    try {
                        // laravel validate message
                        let errors = [];
                        for (let field in xhr.responseJSON.errors) {
                            errors.push(xhr.responseJSON.errors[field].join("\n"));
                        }
                        message = errors.join("\n");
                    } catch (e) {

                    }
                    if (!message) {
                        message = xhr.responseText || error;
                    }

                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                    }).fire({
                        icon: 'error',
                        title: message
                    });
                }
            }
        },
        complete: function () {
            toggleLoadingProgress(false);
        }
    });
});
