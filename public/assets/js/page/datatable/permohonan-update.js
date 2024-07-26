$("#permohonan-update-datatable").DataTable({
    serverSide: true,
    processing: true,
    ajax: "/admin/permohon-update",
    order: [[1, "desc"]],
    columns: [
        {
            data: "DT_RowIndex",
            orderable: false,
            searchable: false,
            className: "text-center",
            width: 20,
        },
        {
            data: "barantin.nama_perusahaan",
            name: "barantin.nama_perusahaan",
        },
        {
            data: "barantin.preregister.pemohon",
            name: "barantin.preregister.pemohon",
            render: function (data) {
                return pemohon(data);
            },
        },
        {
            data: "barantin.preregister.jenis_perusahaan",
            name: "barantin.preregister.jenis_perusahaan",
            render: function (data) {
                return perusahaanpemohon(data);
            },
        },
        {
            data: "barantin.jenis_perusahaan",
            name: "barantin.jenis_perusahaan",
        },
        {
            data: "keterangan",
            name: "keterangan",
        },
        {
            data: "persetujuan",
            name: "persetujuan",
            className: "text-center",
            render: function (data) {
                return persetujuan(data);
            },
        },
        {
            data: "status_update",
            name: "status_update",
            className: "text-center",
            render: function (data) {
                return statusUpdate(data);
            },
        },
        {
            data: "action",
            orderable: false,
            searchable: false,
            className: "text-center",
            width: 60,
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

function statusUpdate(data) {
    switch (data) {
        case "proses":
            return '<h5><span class="badge text-dark bg-warning">PROSES</span></h5>';
        case "selesai":
            return '<h5><span class="badge bg-success">SELESAI</span></h5>';
        case "gagal":
            return '<h5><span class="badge bg-danger">GAGAL</span></h5>';
    }
}
function persetujuan(data) {
    switch (data) {
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
            return `<h5><span class="badge bg-info">${data}</span></h5>`;
        case "cabang":
            return `<h5><span class="badge bg-primary">${data}</span></h5>`;
        default:
            return null;
    }
}
function pemohon(data) {
    switch (data) {
        case "perusahaan":
            return `<h5><span class="badge bg-warning text-dark">${data}</span></h5>`;
        case "perorangan":
            return `<h5><span class="badge bg-secondary">${data}</span></h5>`;
    }
}
