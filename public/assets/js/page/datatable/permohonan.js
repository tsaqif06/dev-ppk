table = $("#permohonan-datatable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/admin/permohonan",
    language: {
        paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>",
        },
    },
    order: [[2, "asc"]],
    columns: [
        {
            data: "DT_RowIndex",
            searchable: false,
            orderable: false,
        },
        {
            data: "action",
            searchable: false,
            orderable: false,
            width: 60,
        },
        {
            data: "status",
            name: "status",
        },
        {
            data: "blockir",
            name: "blockir",
            render: function (data) {
                return BlokirStatus(data);
            },
        },
        {
            data: "barantin.preregister.pemohon",
            name: "barantin.preregister.pemohon",
            render: function (data) {
                return pemohonRender(data)
            }
        },
        {
            data: "barantin.preregister.jenis_perusahaan",
            name: "barantin.preregister.jenis_perusahaan",
            render: function (data) {
                return identifikasiRender(data)
            }
        },
        {
            data: "upt",
            name: "master_upt_id",
        },
        {
            data: "barantin.nama_perusahaan",
            name: "barantin.nama_perusahaan",
        },
        {
            data: "barantin.jenis_identitas",
            name: "barantin.jenis_identitas",
        },
        {
            data: "barantin.nomor_identitas",
            name: "barantin.nomor_identitas",
        },
        {
            data: "barantin.telepon",
            name: "barantin.telepon",
        },
        {
            data: "barantin.fax",
            name: "barantin.fax",
        },
        {
            data: "barantin.email",
            name: "barantin.email",
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
            data: "barantin.alamat",
            name: "barantin.alamat",
        },
        {
            data: "barantin.status_import",
            name: "barantin.status_import",
            orderable: false,
            render: function (data) {
                switch (data) {
                    case 25:
                        return "Importir Umum";
                    case 26:
                        return "Importir Produsen";
                    case 27:
                        return "Importir Terdaftar";
                    case 28:
                        return "Agen Tunggal";
                    case 29:
                        return "BULOG";
                    case 30:
                        return "PERTAMINA";
                    case 31:
                        return "DAHANA";
                    case 32:
                        return "IPTN";
                    default:
                        return "Tidak Diketahui";
                }
            },
        },
        {
            data: "updated_at",
            name: "updated_at",
            render: function (data) {
                return moment(data).format("DD-MM-YYYY");
            },
        },

        { data: "keterangan", name: "keterangan" },
    ],
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
});

function BlokirStatus(data) {
    switch (data) {
        case 0:
            return '<h5><span class="badge bg-success">NONAKTIF</span></h5>';
        case 1:
            return '<h5><span class="badge bg-danger">AKTIF</span></h5>';
    }
}
function pemohonRender(data) {
    switch (data) {
        case 'perusahaan':
            return `<h5><span class="badge bg-warning text-dark">${data}</span></h5>`;
        case 'perorangan':
            return `<h5><span class="badge bg-secondary">${data}</span></h5>`;

    }
}
function identifikasiRender(data) {
    switch (data) {
        case 'cabang':
            return `<h5><span class="badge bg-info">${data}</span></h5>`;
        case 'induk':
            return `<h5><span class="badge bg-primary">${data}</span></h5>`;
        default:
            return null;
    }
}
/* table filter handler */
$("#filter-status-import").select2();
$("#filter-status-import").change(function () {
    var val = $(this).val();
    if (val === "all")
        return table.column("barantin.status_import:name").search("").draw();
    return table.column("barantin.status_import:name").search(val).draw();
});
$("#tanggal-register").daterangepicker();
$("#tanggal-register").on("apply.daterangepicker", function (ev, picker) {
    var startDate = picker.startDate.format("YYYY-MM-DD");
    var endDate = picker.endDate.format("YYYY-MM-DD");
    table
        .column("updated_at:name")
        .search(startDate + " - " + endDate)
        .draw();
});
$("#tanggal-register").on("cancel.daterangepicker", function (ev, picker) {
    table.column("updated_at:name").search("").draw();
});
$("#filter-upt").change(function () {
    var val = $(this).val();
    if (val === "all")
        return table.column("master_upt_id:name").search("").draw();
    return table.column("master_upt_id:name").search(val).draw();
});
