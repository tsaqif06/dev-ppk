$("#status-datatable").dataTable({
    processing: true,
    serverSide: true,
    ajax: "/register/status",
    order: [["7", "desc"]],
    columns: [
        {
            data: "DT_RowIndex",
            orderable: false,
            searchable: false,
        },
        {
            data: "barantin.nama_perusahaan",
            name: "barantin.nama_perusahaan",
        },
        {
            data: "preregister.pemohon",
            name: "preregister.pemohon",
            render: function (data) {
                return pemohon(data);
            },
        },
        {
            data: "preregister.jenis_perusahaan",
            name: "preregister.jenis_perusahaan",
            render: function (data) {
                return perusahaanpemohon(data);
            },
        },
        {
            data: "barantin.nama_tdd",
            name: "barantin.nama_tdd",
        },
        {
            data: "barantin.jabatan_tdd",
            name: "barantin.jabatan_tdd",
        },
        {
            data: "kota",
            name: "kota",
        },
        {
            data: "upt",
            name: "upt",
        },
        {
            data: "updated_at",
            name: "updated_at",
            render: function (data) {
                return moment(data).format("DD-MM-YYYY");
            },
        },
        {
            data: "status",
            name: "status",
            className: "text-center",
            render: function (data) {
                return persetujuan(data);
            },
        },
        {
            data: "keterangan",
            name: "keterangan",
        },
    ],
    language: {
        paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>",
        },
    },
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
});
function persetujuan(data) {
    switch (data.toLowerCase()) {
        case "menunggu":
            return '<h5><span class="badge text-dark bg-warning">MENUNGGU</span></h5>';
        case "disetujui":
            return '<h5><span class="badge bg-success">DISETUJUI</span></h5>';
        case "ditolak":
            return '<h5><span class="badge bg-danger">DITOLAK</span></h5>';
    }
}
function perusahaanpemohon(data) {
    switch (data) {
        case "induk":
            return '<h5><span class="badge bg-info">INDUK</span></h5>';
        case "cabang":
            return '<h5><span class="badge bg-secondary">CABANG</span></h5>';
        default:
            return null;
    }
}
function pemohon(data) {
    switch (data) {
        case "perusahaan":
            return '<h5><span class="badge bg-primary">PERUSAHAAN</span></h5>';
        case "perorangan":
            return '<h5><span class="badge bg-success">PERORANGAN</span></h5>';
    }
}
