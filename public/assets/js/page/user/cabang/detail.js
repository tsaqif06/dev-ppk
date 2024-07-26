status_import = $('#user-cabang-detail').data('status-import');
cabang_id = $('#user-cabang-detail').data('id');

$('#status_import').val(status_import).trigger('change');
$('#table-detail-dokumen').DataTable({
    processing: true,
    ajax: '/barantin/cabang/pendukung/datatable/' + cabang_id + '?response=detail',
    searching: false,
    ordering: false,
    lengthChange: false,
    columns: [{
        data: 'DT_RowIndex'
    },
    {
        data: 'jenis_dokumen'
    },
    {
        data: 'nomer_dokumen'
    },
    {
        data: 'tanggal_terbit'
    },
    {
        data: 'file',
    },
    ],
    language: {
        paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>",
        },
    },
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass(
            "pagination-rounded"
        );
    },
});
$('#table-detail-upt').DataTable({
    processing: true,
    ajax: '/barantin/cabang/upt/detail/' + cabang_id,
    searching: false,
    ordering: false,
    lengthChange: false,
    columns: [{
        data: 'DT_RowIndex'
    },
    {
        data: 'upt',
        name: 'upt'
    },
    {
        data: 'created_at',
        name: 'created_at',
        render: function (data) {
            return moment(data).format('DD-MM-YYYY');
        }
    },
    {
        data: 'updated_at',
        name: 'updated_at',
        render: function (data) {
            return moment(data).format('DD-MM-YYYY');
        }
    },
    {
        data: 'status',
        name: 'status'
    },
    {
        data: 'blockir',
        name: 'blockir',
        render: function (data) {
            return BlokirStatus(data);
        }
    },
    {
        data: 'keterangan',
        name: 'keterangan'
    },
    ],
    language: {
        paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>",
        },
    },
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass(
            "pagination-rounded"
        );
    },
});
function BlokirStatus(data) {
    switch (data) {
        case 0:
            return '<h5><span class="badge bg-success">NONAKTIF</span></h5>'
        case 1:
            return '<h5><span class="badge bg-danger">AKTIF</span></h5>'
    }
}
