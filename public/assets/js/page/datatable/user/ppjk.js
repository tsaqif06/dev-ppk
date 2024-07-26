$("#user-ppjk-datatable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/barantin/ppjk",
    order: [[1, "asc"]],
    columns: [
        {
            data: "DT_RowIndex",
            orderable: false,
            searchable: false,
            width: 40,
        },
        {
            data: "action",
            orderable: false,
            searchable: false,
            width: 60,
        },
        {
            data: "nama_ppjk",
            name: "nama_ppjk",
        },
        {
            data: "email_ppjk",
            name: "email_ppjk",
        },
        {
            data: "tanggal_kerjasama_ppjk",
            name: "tanggal_kerjasama_ppjk",
        },
        {
            data: "negara",
            name: "negara",
        },
        {
            data: "provinsi",
            name: "provinsi",
        },
        {
            data: "kota",
            name: "kota",
        },
        {
            data: "alamat_ppjk",
            name: "alamat_ppjk",
        },
        {
            data: "status_ppjk",
            name: "status_ppjk",
            render: function (data) {
                return Status(data);
            },
        },
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
});

function Status(data) {
    switch (data) {
        case "AKTIF":
            return '<h5><span class="badge bg-success">AKTIF</span></h5>';
        case "NONAKTIF":
            return '<h5><span class="badge bg-danger">NONAKTIF</span></h5>';
    }
}
