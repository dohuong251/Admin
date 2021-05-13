let images = document.querySelectorAll("img"), loadingIcon = $('.loading-icon');
lazyload(images);

let localeDateFormat = "DD/MM/YYYY";
let serverDateFormat = "YYYY-MM-DD";

$(document).ready(function () {
    // setup ajax thêm csrf token vào header (cơ chế của laravel)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // chuyển trang khi click vào hàng trong bảng
    $('table tr th, table tr td').click(function (event) {
        // nếu ô click có checkbox, click vào checkbox, không chuyển trang
        if ($(event.target).prop("tagName").toLowerCase() === 'th' || $(event.target).prop("tagName").toLowerCase() === 'td') {
            let checkbox = $(this).find('input[type=checkbox]');
            if (checkbox.length > 0) {
                checkbox.click();
                return;
            }
        }

        // chuyển đến trang trong thuộc tính data-href của row nếu không phải click vào checkbox, thẻ a hoặc thẻ có class except-redirect
        if (event.target.type !== 'checkbox' && !$(event.target).is('a, .except-redirect *') && $(this).closest('tr').attr('data-href')) {
            window.location.href = $(this).closest('tr').attr('data-href');
        }
    });

    // ẩn hiện thông tin, edit form trong màn thông tin
    $('.toggle-display').click(function () {
        let toggleView = $('.toggle-display-des');
        if (toggleView.parent().hasClass('justify-content-end')) {
            toggleView.parent().removeClass('justify-content-end');
            return;
        }
        toggleView.first().before(toggleView.last());
        if (toggleView.first().prop("tagName").toLowerCase() === "div") {
            toggleView.first().addClass('slideInLeft');
        } else {
            toggleView.first().addClass('slideInRight');
        }
    });

    $('.chat-sidebar-toggle').click(e => {
        // ẩn hiện menu chat (màn hình nhỏ)
        $('#chat-sidebar').toggleClass('open');
        e.preventDefault();
    });
});

function confirmDelete(form) {
    return confirm('Bạn chắc chắn muốn xóa');
}

/**
 * tạo sticky header cho table khi scroll
 * @param jTable: jquery table
 */
function initTableStickyHeader(jTable) {
    try {
        jTable.stickyTableHeaders({
            fixedOffset: $('.header'),
            // scrollableArea: $('.full-container')
        });

        jTable.parent().addClass('table-responsive-md ovX-a').scroll(function () {
            $(window).trigger('resize.stickyTableHeaders');
        });
    } catch (e) {
        console.warn(e);
    }
}


/**
 *
 * @param date: chuỗi date server trả về (định dạng: năm-tháng-ngày)
 */
function parseServerDate(date) {
    try {
        return moment(date, serverDateFormat);
    } catch (e) {
        console.warn(e);
    }
}


/**
 * khởi tạo datatable
 * @param table: jquery table
 * @param options: datatable option
 * @param selectable: true - checkbox on each row
 * @param stickyHeader: true - sticky header on scroll
 */
function initDatatable(table, options, selectable = true, stickyHeader = true) {
    try {
        if (selectable) {
            options.drawCallback = function (settings) {
                lazyload(document.querySelectorAll("img"));
                table.find('tbody').addClass('cur-p');
                if (stickyHeader) {
                    // initTableStickyHeader(table);
                }
                $(this).find('tbody tr td').click(function (e) {
                    // if (e.target.type !== 'checkbox') {
                    window.location.href = $(this).parent().find('.select-row').attr('data-href');
                    // }
                });

                $(this).find('tbody tr td:has(input[type="checkbox"])').unbind('click').click(function (e) {
                    if (e.target.type !== 'checkbox') {
                        let checkbox = $(this).find("input[type='checkbox']");
                        checkbox.click();
                    }
                });
                let selectAllBox = $(this).find('#selectAll');
                if (selectAllBox.length) {
                    if (selectAllBox.prop('checked')) selectAllBox.click()
                }
            }
        }
        table.DataTable(options);
    } catch (e) {
        console.warn(e);
    }
}

function toggleLoadingProgress(isShow) {
    if (isShow) loadingIcon.show();
    else loadingIcon.hide()
}
