let id_pre_register = $("#datatable-dokumen-pendukung").data("pre-register");

$(".select-item").select2({
    placeholder: "select item",
    minimumResultsForSearch: -1,
});
$(".negara-select").on("change", function () {
    let val = $(this).val();
    if (val == 99) {
        $("#kota-form").removeClass("d-none");
        $("#provinsi-form").removeClass("d-none");
    } else {
        $("#kota-form").addClass("d-none");
        $("#provinsi-form").addClass("d-none");
    }
});

$("#file_dokumen").dropify();

var phoneInput = $("#telepon");
IMask(phoneInput[0], {
    mask: "0000-0000-0000",
    lazy: false,
});
var phoneInputCp = $("#telepon_cp");
IMask(phoneInputCp[0], {
    mask: "0000-0000-0000",
    lazy: false,
});
var FaxInput = $("#fax");
IMask(FaxInput[0], {
    mask: "(000) 000-0000",
    lazy: false,
});

$('input[name="kuasa"]').change(function () {
    let val = $(this).val();
    if (val === "ya") {
        $("#form-kuasa").removeClass("d-none");
        return;
    }
    $("#form-kuasa").addClass("d-none");
});
let table_dokumen_pendukung = $("#datatable-dokumen-pendukung").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/register/pendukung/datatable/" + id_pre_register,
    searching: false,
    ordering: false,
    lengthChange: false,
    columns: [
        {
            data: "DT_RowIndex",
        },
        {
            data: "jenis_dokumen",
        },
        {
            data: "nomer_dokumen",
        },
        {
            data: "tanggal_terbit",
        },
        {
            data: "file",
        },
        {
            data: "action",
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

$("#button-pendukung").click(function () {
    form_data = new FormData();
    let file = $("#file_dokumen").prop("files")[0];
    form_data.append("file_dokumen", file ?? "");

    let form = $("#form-pendukung").serializeArray();
    $.each(form, function (key, value) {
        form_data.append(value.name, value.value);
    });

    $.ajax({
        data: form_data,
        url: "/register/pendukung/store/" + id_pre_register,
        processData: false,
        contentType: false,
        type: "POST",
        dataType: "json",
        beforeSend: function () {
            $(".form-control-dokumen").removeClass("is-invalid");
            $(".invalid-feedback").empty();
            $("#button-pendukung").addClass("disabled").html("Loading...");
        },
        success: function (response) {
            if (response.status) {
                notif("success", response.message);
                table_dokumen_pendukung.draw();
                $("#form-pendukung").trigger("reset");
                $(".dropify-clear").trigger("click");
                $("#button-pendukung").removeClass("disabled").html("tambah");
            } else {
                notif("error", response.message);
                $("#button-pendukung").removeClass("disabled").html("tambah");
            }
        },
        error: function (response) {
            $("#button-pendukung").removeClass("disabled").html("tambah");
            var respon = response.responseJSON;
            var error = respon.errors;
            if (respon && error) {
                $.each(error, function (key, value) {
                    $("#" + key).addClass("is-invalid");
                    $("#" + key + "-feedback")
                        .addClass("d-block")
                        .html(value);
                });
                notif("error", "data tidak valid.");
                return;
            }
            notif("error", "terjadi kesalahan");
        },
    });
});

$("#button-submit").click(function () {
    form_data = new FormData();

    let form_ttd = $("#form-penandatangan").serializeArray();
    let form_cp = $("#form-cp").serializeArray();
    let form_register = $("#form-register").serializeArray();
    let form_ketentuan = $("#form-ketentuan").serializeArray();

    $.each(form_ttd, function (key, value) {
        form_data.append(value.name, value.value);
    });
    $.each(form_cp, function (key, value) {
        form_data.append(value.name, value.value);
    });
    $.each(form_register, function (key, value) {
        form_data.append(value.name, value.value);
    });
    $.each(form_ketentuan, function (key, value) {
        form_data.append(value.name, value.value);
    });
    $.ajax({
        data: form_data,
        url: "/register/store/perorangan/" + id_pre_register,
        processData: false,
        contentType: false,
        type: "POST",
        dataType: "json",
        beforeSend: function () {
            $(".form-control").removeClass("is-invalid");
            $(".invalid-feedback").empty();
            $("#button-submit").addClass("disabled").html("Loading...");
        },
        success: function (response) {
            if (response.status) {
                notif("success", response.message);
                $("#button-submit").removeClass("disabled").html("Submit");
                location.reload();
            } else {
                notif("error", response.message);
                $("#button-submit").removeClass("disabled").html("Submit");
            }
        },
        error: function (response) {
            $("#button-submit").removeClass("disabled").html("Submit");
            var respon = response.responseJSON;
            var error = respon.errors;
            if (respon && error) {
                $.each(error, function (key, value) {
                    $("#" + key).addClass("is-invalid");
                    $("#" + key + "-feedback")
                        .addClass("d-block")
                        .html(value);
                });
                notif("error", "data tidak valid.");
                return;
            }
            notif("error", respon.message ?? "terjadi kesalahan");
        },
    });
});

// $('#datatable-kuasa').DataTable({
//     language: {
//         paginate: {
//             previous: "<i class='mdi mdi-chevron-left'>",
//             next: "<i class='mdi mdi-chevron-right'>",
//         },
//     },
//     drawCallback: function () {
//         $(".dataTables_paginate > .pagination").addClass(
//             "pagination-rounded"
//         );
//     },
// });
// $('#datatable').DataTable({
//     language: {
//         paginate: {
//             previous: "<i class='mdi mdi-chevron-left'>",
//             next: "<i class='mdi mdi-chevron-right'>",
//         },
//     },
//     drawCallback: function () {
//         $(".dataTables_paginate > .pagination").addClass(
//             "pagination-rounded"
//         );
//     },
// });
