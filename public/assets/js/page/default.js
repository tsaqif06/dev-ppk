$(document).ready(function () {
    let _data_update;
    let _data_lama;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        error: function (response) {
            if (response.responseText) {
                var error = JSON.parse(response.responseText);
                if (error.code === 401) {
                    window.location.href = "/";
                }
            }
        },
    });
});

function logout(url) {
    Swal.fire({
        title: "Apa kamu yakin ?",
        text: "Anda tidak akan bisa akses halaman ini lagi!",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "KELUAR",
        cancelButtonText: "CANCEL",
        confirmButtonClass: "btn btn-success mt-2",
        cancelButtonClass: "btn btn-danger ms-2 mt-2",
        buttonsStyling: !1,
    }).then(function (t) {
        t.value
            ? $.post(url, function () {
                window.location.href = "/";
            })
            : t.dismiss === Swal.DismissReason.cancel;
    });
}
function modal(label, size, backdrop, url) {
    $("#modal-dialog").addClass("modal-dialog " + size);
    $("#modal-label").html(label);
    $("#modal-data").attr("data-bs-backdrop", backdrop);
    $("#spinner").clone().removeClass("d-none").appendTo("#modal-body");
    $("#modal-body").load(url);
    $("#modal-data").modal("show");
}

$("#modal-data").on("hidden.bs.modal", function (e) {
    $("#modal-dialog").removeClass();
    $("#modal-label").html("");
    $("#modal-data").attr("data-bs-backdrop", "true");
    $("#modal-body").empty();
});

function ShowPage(url) {
    let status_import = null;
    let cabang_id = null;
    $("#page-index").hide();
    $("html, body").animate({ scrollTop: 0 }, 400);
    $("#page-grid")
        .empty()
        .append(
            '<div class="text-center mt-5"><div class="spinner-border"  style="width: 3rem; height: 3rem;"></div></div>'
        );
    $("#page-grid").load(url);
}
function ShowPageSub(url) {
    $("#page-sub-index").hide();
    $("html, body").animate({ scrollTop: 0 }, 400);
    $("#page-sub-grid")
        .empty()
        .append(
            '<div class="text-center mt-5"><div class="spinner-border"  style="width: 3rem; height: 3rem;"></div></div>'
        );
    $("#page-sub-grid").load(url);
}

function ClosePage() {
    $("#page-grid").empty();
    $("html, body").animate({ flipInX: 0 }, 400);
    $("#page-index").show();
}

function ClosePageSub() {
    $("#page-sub-grid").empty();
    $("html, body").animate({ flipInX: 0 }, 400);
    $("#page-sub-index").show();
}

function ClosePageLink(url) {
    $("#page-grid").empty();
    $("html, body").animate({ flipInX: 0 }, 400);
    if (url) {
        $("#page-grid")
            .empty()
            .append(
                '<div class="text-center mt-5"><div class="spinner-border"  style="width: 3rem; height: 3rem;"></div></div>'
            );
        $("#page-grid").load(url);
    } else {
        $("#page-index").show();
    }
}
function CreateCabang(url) {
    let id_pre_register = null;
    let table_dokumen_pendukung = null;
    $("#page-index").hide();
    $("html, body").animate({ scrollTop: 0 }, 400);
    $("#page-grid")
        .empty()
        .append(
            '<div class="text-center mt-5"><div class="spinner-border"  style="width: 3rem; height: 3rem;"></div></div>'
        );
    $("#page-grid").load(url);
}

/* only table load */

function TableLoaded(url, table_name) {
    let table = null;
    $(table_name).DataTable().destroy();
    $("#table-loaded")
        .empty()
        .append(
            '<div class="text-center mt-5"><div class="spinner-border"  style="width: 3rem; height: 3rem;"></div></div>'
        );
    $("#table-loaded").load(url);
    // $('#filter-status-import').length > 0 && $('#filter-upt').empty().trigger('change');
    // $('#filter-status-import').length > 0 && $('#filter-status-import').val('all').trigger('change');
}

function submit(url, image) {
    if (image) {
        form_data = new FormData();
        let fileInput = $("input[type=file]");
        fileInput.each(function (index, input) {
            var files = input.files;
            if (files.length > 0) {
                form_data.append(input.name, files[0]);
            }
        });
        let form = $("#form-data").serializeArray();
        $.each(form, function (key, value) {
            form_data.append(value.name, value.value);
        });
        if ($("#import-file").length > 0) {
            return FormImport(url, form_data);
        }
        return FormSendImage(url, form_data);
    }
    var data = $("#form-data").length
        ? $("#form-data").serialize()
        : $(".form-data").serialize();
    FormSend(url, data);
}

function FormSend(url, data) {
    $.ajax({
        data: data,
        url: url,
        dataType: "json",
        type: "post",
        beforeSend: function () {
            $(".form-control").removeClass("is-invalid");
            $(".invalid-feedback").empty();
            $("#button-submit").addClass("disabled").html("Loading...");
        },
        success: function (response) {
            if (response.status) {
                notif("success", response.message);
                response.table && TableReload(response.table);
                $("#modal-data").modal("hide");
            } else {
                notif("error", response.message);
                $("#button-submit").removeClass("disabled").html("Simpan");
            }
        },
        error: function (response) {
            $("#button-submit").removeClass("disabled").html("Simpan");
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
}

function notif(type, message) {
    toastr[type](message);
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: 300,
        hideDuration: 1000,
        timeOut: 1500,
        extendedTimeOut: 1000,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
}

function TableReload(table) {
    var table = $("#" + table).DataTable();
    table.ajax.reload();
}
function DeleteAlert(url, type) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda akan kehilangan data " + type,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                success: function (response) {
                    if (response.status) {
                        notif("success", response.message);
                        TableReload(response.table);
                    } else {
                        notif("error", response.message);
                    }
                },
                error: function (response) {
                    notif("error", "data gagal di hapus");
                },
            });
        }
    });
}

function ConfirmRegister(url, type, urlReload) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda ingin menerima " + type,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Terima",
        cancelButtonText: "Tolak",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    status: "DISETUJUI",
                },
                success: function (response) {
                    if (response.status) {
                        notif("success", response.message);
                        TableReload(response.table);
                        if (urlReload) {
                            ClosePageLink(urlReload);
                        }
                    } else {
                        notif("error", response.message);
                    }
                },
                error: function (response) {
                    notif(
                        "error",
                        response.message ?? "register gagal di aprove"
                    );
                },
            });
        }
        if (result.dismiss === "cancel") {
            $("#url-tolak").val(url);
            if (urlReload) {
                $("#url-reload").val(urlReload);
            }
            $("#form-tolak").trigger("reset");
            $("#modal-tolak-keterangan").modal("show");
        }
    });
}
$("#button-tolak").click(function () {
    let linkReload = $("#url-reload").val();
    $.ajax({
        url: $("#url-tolak").val(),
        type: "POST",
        data: {
            status: "DITOLAK",
            keterangan: $("#keterangan-tolak").val(),
        },
        success: function (response) {
            $("#modal-tolak-keterangan").modal("hide");
            if (response.status) {
                notif("warning", response.message);
                TableReload(response.table);
                if (linkReload) {
                    ClosePageLink(linkReload);
                }
            } else {
                notif("error", response.message);
            }
        },
        error: function (response) {
            $("#modal-tolak-keterangan").modal("hide");
            notif("error", response.message ?? "register gagal di aprove");
        },
    });
});

$("#button-blok").click(function () {
    let linkReload = $("#url-reloadd").val();
    $.ajax({
        url: $("#url-blokir").val(),
        type: "POST",
        data: {
            status: "DITOLAK",
            keterangan: $("#keterangan-blok").val(),
        },
        success: function (response) {
            $("#modal-blokir").modal("hide");
            if (response.status) {
                notif("warning", response.message);
                TableReload(response.table);
                if (linkReload) {
                    ClosePageLink(linkReload);
                }
            } else {
                notif("error", response.message);
            }
        },
        error: function (response) {
            $("#modal-blokir").modal("hide");
            notif("error", response.message ?? "Account gagal di blokir");
        },
    });
});

function Block(url, type, urlReload) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda ingin memblokir " + type,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "BLOKIR",
        cancelButtonText: "BATAL",
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan modal keterangan
            $("#url-blokir").val(url);
            if (urlReload) {
                $("#url-reloadd").val(urlReload);
            }
            $("#form-blokir").trigger("reset");
            $("#modal-blokir").modal("show");

            // Tambahkan event listener untuk submit form pada modal keterangan
            $("#form-blokir").off('submit').on('submit', function (e) {
                e.preventDefault();

                // Ambil data keterangan
                const keterangan = $("#keterangan-blok").val();

                // Kirim permintaan AJAX
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        status: "BLOCKIR",
                        keterangan: keterangan,
                    },
                    success: function (response) {
                        if (response.status) {
                            notif("info", response.message);
                            TableReload(response.table);
                            if (urlReload) {
                                ClosePageLink(urlReload);
                            }
                        } else {
                            notif("error", response.message);
                        }
                    },
                    error: function (response) {
                        notif(
                            "error",
                            response.message ?? "register gagal di blockir"
                        );
                    },
                });

                // Tutup modal setelah submit
                $("#modal-tolak-keterangan").modal("hide");
            });
        }
        if (result.dismiss === "cancel") {
             // Canceled: Tidak ada aksi tambahan
        }
    });
}


function Open(url, type, urlReload) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda ingin membuka blokir " + type,
        icon: "question",
        // showCancelButton: true,
        confirmButtonColor: "#3085d6",
        // cancelButtonColor: "#d33",
        confirmButtonText: "BUKA",
        // cancelButtonText: "BLOCKIR",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    status: "BLOCKIR",
                },
                success: function (response) {
                    if (response.status) {
                        notif("success", response.message);
                        TableReload(response.table);
                        if (urlReload) {
                            ClosePageLink(urlReload);
                        }
                    } else {
                        notif("error", response.message);
                    }
                },
                error: function (response) {
                    notif(
                        "error",
                        response.message ?? "register gagal di blockir"
                    );
                },
            });
        }
        if (result.dismiss === "cancel") {
            $("#url-tolak").val(url);
            $("#form-tolak").trigger("reset");
            $("#modal-tolak-keterangan").modal("show");
        }
    });
}
function Changeprofile() {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda ingin mengubah profile anda",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Ubah",
        cancelButtonText: "Tidak",
    }).then((result) => {
        if (result.isConfirmed) {
            modal(
                "Alasan Perubahan",
                "modal-mb",
                "static",
                "/barantin/profile/form-keterangan-update"
            );
        }
        if (result.dismiss === "cancel") {
            // $('#url-tolak').val(url)
            // $('#form-tolak').trigger('reset')
            // $('#modal-tolak-keterangan').modal('show')
        }
    });
}

function CreateUser(url, text, urlReload) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Ingin membuat user barantin " + text,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Buat",
        cancelButtonText: "Tidak",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                success: function (response) {
                    TableReload(response.table);
                    notif(
                        "success",
                        "user berhasil " + response.nama + " dibuat"
                    );
                    if (urlReload) {
                        ClosePageLink(urlReload);
                    }
                },
                error: function (response) {
                    notif("error", "username & password gagal dibuat");
                },
            });
        }
        if (result.dismiss === "cancel") {
        }
    });
}

function UserSetting(url, text, urlReload) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Ingin merubah user barantin " + text,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Kirim username & password",
        cancelButtonText: "Tidak",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    reset: "true",
                },
                success: function (response) {
                    TableReload(response.table);
                    notif(
                        "success",
                        "username & password berhasil " +
                        response.nama +
                        " diubah"
                    );
                    if (urlReload) {
                        ClosePageLink(urlReload);
                    }
                },
                error: function (response) {
                    notif("error", "username & password gagal diubah");
                },
            });
        }
        if (result.dismiss === "cancel") {
        }
    });
}

function alertBlockirUser() {
    Swal.fire({
        title: "User Belum dibuat",
        text: "Silahkan buat user untuk akses blockir user",
        icon: "warning",
        confirmButtonColor: "#0f9cf3",
    });
}

function ConfirmCabang(url, type) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: `Anda ingin menyetujui cabang ${type}`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Terima",
        cancelButtonText: "Tolak",
    }).then((result) => {
        if (result.isConfirmed || result.dismiss === "cancel") {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    status: result.isConfirmed ? "DISETUJUI" : "DITOLAK",
                },
                success: function (response) {
                    if (response.status) {
                        notif("success", response.message);
                        TableReload(response.table);
                    } else {
                        notif("error", response.message);
                    }
                },
                error: function (response) {
                    notif(
                        "error",
                        response.message ?? "register gagal di aprove"
                    );
                },
            });
        }
    });
}
function ConfirmUpdatePersetujuan(url, type) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda ingin menyetujui update " + type,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Terima",
        cancelButtonText: "Tolak",
    }).then((result) => {
        if (result.isConfirmed || result.dismiss === "cancel") {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    persetujuan: result.isConfirmed ? "disetujui" : "ditolak",
                },
                success: function (response) {
                    if (response.status) {
                        notif("success", response.message);
                        TableReload(response.table);
                    } else {
                        notif("error", response.message);
                    }
                },
                error: function (response) {
                    notif(
                        "error",
                        response.message ?? "persetujuan gagal di aprove"
                    );
                },
            });
        }
    });
}
function ConfirmUpdate(url, type) {
    Swal.fire({
        title: "Apa Anda Yakin?",
        text: "Anda ingin verifikasi update " + type,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Verifikasi",
        cancelButtonText: "Tolak",
    }).then((result) => {
        if (result.isConfirmed || result.dismiss == "cancel") {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    status: result.isConfirmed ? 'disetujui' : 'ditolak',
                    _method: 'PATCH'
                },
                success: function (response) {
                    notif("success", response.message);
                    TableReload(response.table);
                    ClosePage();
                },
                error: function (response) {
                    notif(
                        "error",
                        response.message ?? "register gagal di aprove"
                    );
                },
            });
        }
    });
}