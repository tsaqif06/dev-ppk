<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Permohonan Update</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Permohonan Update</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @switch($data->persetujuan)
                        @case('menunggu')
                            <button class="btn btn-warning btn-sm me-2" onclick="ConfirmUpdate('{{ route('admin.permohonan-update.update', $data->id) }}', '{{ $data->barantin->nama_perusahaan }}')">VERIFIKASI</button>
                        @break

                        @case('disetujui')
                            <button class="btn btn-success btn-sm me-2" id="btn-status" disabled>DISETUJUI</button>
                        @break

                        @default
                            <button class="btn btn-danger btn-sm me-2" id="btn-status" disabled>DITOLAK</button>
                    @endswitch
                    <button class="btn btn-danger btn-sm" onclick="ClosePage()">Close</button>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-6 col-sm-12">
                        <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                        <label for="" class="form-label fw-bold h6 mt-0 mb-0">Data</label>
                        <hr class="mt-0 mb-3">
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="text" id="nama_perusahaan" name="nama_perusahaan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Pemohon</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="text" value="{{ $data->barantin->preregister->pemohon }}">
                            </div>
                        </div>
                        <div class="row
                                    mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Jenis Perusahaan</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="text" id="jenis_perusahaan" name="jenis_perusahaan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis Identitas</label>
                            <div class="col">
                                <input disabled class="form-control select-item" type="text" placeholder="Jenis Identitas" id="jenis_identitas">
                            </div>
                            <div class="col">
                                <input class="form-control" type="number" disabled placeholder="Nomor Identitas" id="nomor_identitas">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="upt" class="col-sm-3 col-form-label">Telephon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telepon" disabled required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" placeholder="Fax" disabled id="fax">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="email" placeholder="Email" id="email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status_import" class="col-sm-3 col-form-label">Status Import</label>
                            <div class="col-sm-9">
                                <input class="form-control select-item" disabled id="status_import">
                                <div class="invalid-feedback" id="status_import-feedback"></div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <label for="status_import" class="col-sm-3 col-form-label">Lingkup Aktifitas</label>
                            <div class="col-sm-9">
                                <input class="form-control select-item" disabled id="lingkup_aktifitas">
                                <div class="invalid-feedback" id="status_import-feedback"></div>
                            </div>
                        </div>
                        <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                        <label for="" class="form-label fw-bold h6 mt-0 mb-0">Alamat</label>
                        <hr class="mt-0 mb-3">
                        <div class="row mb-3">
                            <label for="negara" class="col-sm-3 col-form-label">Negara</label>
                            <div class="col-sm-9">
                                <input class="form-control negara-select" type="text" id="negara_id" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Provinsi</label>
                            <div class="col-sm-9">
                                <input class="form-control " disabled type="text" id="provinsi_id">
                            </div>
                        </div>

                        <div class="row mb-3" id="kota-form">
                            <label for="kota" class="col-sm-3 col-form-label">Kota/Kab</label>
                            <div class="col-sm-9">
                                <input class="form-control " disabled type="text" id="kota">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <input class="form-control " disabled type="text" id="alamat">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                        <label for="" class="form-label fw-bold h6 mt-0 mb-0">Penandatangan</label>
                        <hr class="mt-0 mb-3">
                        <div>
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input class="form-control " disabled type="text" id="nama_tdd">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jenis_identitas" class="col-sm-3 col-form-label">Jenis
                                    Identitas</label>
                                <div class="col">
                                    <input class="form-control" disabled type="text" id="jenis_identitas_tdd">
                                </div>
                                <div class="col">
                                    <input class="form-control" disabled type="text" id="nomor_identitas_tdd">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled type="text" id="jabatan_tdd">
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled type="text" id="alamat_tdd">
                                </div>
                            </div>
                        </div>

                        <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                        <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kontak Person</label>
                        <hr class="mt-0 mb-3">

                        <div class="row mb-3">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="text" id="nama_cp">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="text" id="alamat_cp">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled type="text" id="telepon_cp">
                            </div>
                        </div>
                    </div>

                </form>
                <div class="table-responsive">
                    <table class="table nowarp w-100 table-bordered" id="table-detail-dokumen">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jenis Dokumen</th>
                                <th>No Dokumen</th>
                                <th>Tanggal Terbit</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @provinsi() --}}
@php
    $dataArray = json_decode($data->temp_update, true);
@endphp

<input type="hidden" id="hidden-negara" value="@negara($dataArray['negara_id'])">
<input type="hidden" id="hidden-provinsi" value="@provinsi($dataArray['provinsi_id'])">
<input type="hidden" id="hidden-kota" value="@kota($dataArray['kota'])">
<input type="hidden" id="hidden-status" value="@statusimport($dataArray['status_import'])">
<input type="hidden" id="hidden-lingkup" value="@aktifitas($dataArray['lingkup_aktifitas'])">
<script>
    $('#table-detail-dokumen').DataTable({
        processing: true,
        ajax: '/admin/permohon-update/{{ $data->id }}/show?datatable=true',
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
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
</script>
<script>
    _data_update = @json($data->temp_update);
    _data_lama = {!! $data->barantin !!}
    $.each(JSON.parse(_data_update), function(index, value) {
        if (_data_lama[index] != value) {
            $(`#${index}`).addClass('is-valid')
        }
        switch (index) {
            case 'provinsi_id':
                $(`#${index}`).val($('#hidden-provinsi').val())
                break;
            case 'kota':
                $(`#${index}`).val($('#hidden-kota').val())
                break;
            case 'negara_id':
                $(`#${index}`).val($('#hidden-negara').val())
                break;
            case 'status_import':
                $(`#${index}`).val($('#hidden-status').val())
                break;
            case 'lingkup_aktifitas':
                $(`#${index}`).val($('#hidden-lingkup').val())
                break
            default:
                return $(`#${index}`).val(value)
        }

    })
</script>
