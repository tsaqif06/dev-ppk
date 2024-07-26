$('#user-upt-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/barantin/upt',
    order: [
        [1, 'asc']
    ],
    columns: [{
        data: 'DT_RowIndex',
        orderable: false,
        searchable: false
    }, {
        data: 'upt',
        name: 'upt'
    }, {
        data: 'status',
        name: 'status',
        render: function (data) {
            return statusRender(data)
        }
    },
    {
        data: 'created_at',
        name: 'created_at',
        render: function (data) {
            return moment(data).format('DD-MM-YYYY')
        }
    },
    {
        data: 'updated_at',
        name: 'updated_at',
        render: function (data) {
            return moment(data).format('DD-MM-YYYY')
        }
    },
    {
        data: 'keterangan',
        name: 'keterangan'
    },
    {
        data: 'blockir',
        name: 'blockir',
        render: function (data) {
            return BlokirStatus(data)
        }
    }
    ],
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
    language: {
        paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>",
        },
    },
})

function statusRender(data) {
    switch (data) {
        case 'DISETUJUI':
            return '<h5><span class="badge bg-success">DISETUJUI</span></h5>'
        case 'DITOLAK':
            return '<h5><span class="badge bg-danger">DITOLAK</span></h5>'
        default:
            return '<h5><span class="badge bg-warning">MENUNGGU</span></h5>'

    }
}
function BlokirStatus(data) {
    switch (data) {
        case 0:
            return '<h5><span class="badge bg-success">NONAKTIF</span></h5>'
        case 1:
            return '<h5><span class="badge bg-danger">AKTIF</span></h5>'
    }
}
