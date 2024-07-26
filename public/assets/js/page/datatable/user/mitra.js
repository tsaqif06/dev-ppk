$('#user-mitra-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/barantin/mitra',
    order: [
        [1, 'asc']
    ],
    columns: [
        {
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: 40,
        },
        {
            data: 'action',
            orderable: false,
            searchable: false,
            width: 60,
        },
        {
            data: 'nama_mitra',
            name: 'nama_mitra'
        },
        {
            data: 'jenis_identitas_mitra',
            name: 'jenis_identitas_mitra'
        },
        {
            data: 'nomor_identitas_mitra',
            name: 'nomor_identitas_mitra',
        },
        {
            data: 'telepon_mitra',
            name: 'telepon_mitra',
        },
        {
            data: 'negara',
            name: 'negara',
            render: function (data, type, row) {
                return data || '<center>-</center>';
            }
        },
        {
            data: 'provinsi',
            name: 'provinsi',
            render: function (data, type, row) {
                return data || '<center>-</center>';
            }
        },
        {
            data: 'kota',
            name: 'kota',
            render: function (data, type, row) {
                return data || '<center>-</center>';
            }
        },
        {
            data: 'alamat_mitra',
            name: 'alamat_mitra',
        },
    ],
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
})

