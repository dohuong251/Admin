let dataTable;
$(document).ready(function () {
    // khởi tạo date picker
    $('#birthday').daterangepicker({
        "singleDatePicker": true,
        "startDate": moment($('#birthday').val(), "YYYY-MM-DD"),
        "opens": "center",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    dataTable = $('#song-table');
    let dataTableOptions = {
        processing: true,
        serverSide: true,
        ajax: dataTable.attr('data-table-source'),
        order: [[5, 'desc']],
        // select: true,
        columns: [
            // data: tên trường trong dữ liệu json gửi về
            {data: 'SongId'},
            {data: 'ImageURL'},
            {data: 'Code'},
            {data: 'Name'},
            {data: 'AverageRating'},
            {data: 'ViewByAll'},
        ],
        columnDefs: [
            {
                targets: [0],
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" class="select-row" class="align-middle" data-href="${row.manage_url}" data-id="${data}">`
                }
            },
            {
                targets: [1],
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (data) return `<img src='${data}' alt="channel_thumb" class="image-fit image-thumb img-thumbnail">`;
                    else return '';
                }
            },
            {
                targets: [5],
                render: function (data, type, row) {
                    return Number(data).toLocaleString();
                }
            },
        ],
    };
    initDatatable(dataTable, dataTableOptions);
});
