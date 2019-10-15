$(document).ready(function () {
    $('.toggle-display').click(function () {
        let toggleView = $('.toggle-display-des');
        toggleView.first().before(toggleView.last());
        if (toggleView.first().prop("tagName").toLowerCase() === "div") {
            toggleView.first().addClass('slideInLeft');
        } else {
            toggleView.first().addClass('slideInRight');
        }
    });

    let dataTable = $('#song-table');
    dataTable.DataTable({
        processing: true,
        serverSide: true,
        // "pagingType": "input",
        // "pagingType": "full_numbers",
        ajax: dataTable.attr('data-table-source'),
        order: [[5, 'desc']],
        // select: true,
        columns: [
            {data: 'SongId'},
            {data: 'ImageURL'},
            {data: 'Code'},
            {data: 'Name'},
            {data: 'RateCount'},
            {data: 'ViewByAll'},
        ],
        columnDefs: [
            {
                targets: [0],
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" class="select-stream select-checkbox" class="align-middle" data-href="${row.manage_url}">`
                }
            },
            {
                targets: [1],
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<img src='${data}' alt="channel_thumb" class="image-fit image-thumb">`;
                }
            },
        ],
        "drawCallback": function (settings) {
            $('#song-table tbody tr td:not(:first-child)').click(function (e) {
                // if (e.target.type !== 'checkbox') {
                window.location.href = $(this).parent().find('.select-stream').attr('data-href');
                // }
            });
            $('#song-table tbody tr td:first-child').click(function (e) {
                if (e.target.type !== 'checkbox') {
                    let checkbox = $(this).find("input[type='checkbox']");
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            });
        },
    });
});
