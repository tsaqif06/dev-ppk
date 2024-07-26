<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pendaftar</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pendaftar</a></li>
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
                            <label for="upt" class="col-sm-3 col-form-label">Perusahaan Induk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telepon" disabled value="{{ auth()->user()->barantin->nama_perusahaan ?? '' }}" name="telepon"
                                    aria-describedby="inputGroupPrepend" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled value="{{ $data->nama_perusahaan ?? '' }}" type="text" id="pemohon" name="pemohon">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                                Identitas</label>
                            <div class="col">
                                <input value="{{ $data->jenis_identitas ?? '' }}" disabled class="form-control select-item" type="text" placeholder="Jenis Identitas">
                            </div>
                            <div class="col">
                                <input class="form-control" type="number" disabled value="{{ $data->nomor_identitas ?? '' }}" placeholder="Nomor Identitas" id="nomor_identitas"
                                    name="nomor_identitas">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="upt" class="col-sm-3 col-form-label">NITKU</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telepon" disabled value="{{ $data->nitku ?? '' }}" name="telepon" aria-describedby="inputGroupPrepend" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="upt" class="col-sm-3 col-form-label">Telephon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telepon" disabled value="{{ $data->telepon ?? '' }}" name="telepon" aria-describedby="inputGroupPrepend" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" placeholder="Fax" disabled value="{{ $data->fax ?? '' }}" id="nomor_fax" name="nomor_fax">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled value="{{ $data->email ?? '' }}" type="email" placeholder="Email" id="email" name="email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status_import" class="col-sm-3 col-form-label">Status Import</label>
                            <div class="col-sm-9">
                                <input class="form-control select-item" disabled value="@statusimport($data->status_import)">
                                <div class="invalid-feedback" id="status_import-feedback"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status_import" class="col-sm-3 col-form-label">Lingkup Aktifitas</label>
                            <div class="col-sm-9">
                                <input class="form-control select-item" disabled value="@aktifitas($data->lingkup_aktifitas)">
                                <div class="invalid-feedback" id="status_import-feedback"></div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <label for="email" class="col-sm-3 col-form-label">Nama Alias</label>
                            <div class="col-sm-9">
                                <input class="form-control" disabled value="{{ $data->nama_alias_perusahaan ?? '' }}">
                            </div>
                        </div>
                        <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                        <label for="" class="form-label fw-bold h6 mt-0 mb-0">Alamat</label>
                        <hr class="mt-0 mb-3">
                        <div class="row mb-3">
                            <label for="negara" class="col-sm-3 col-form-label">Negara</label>
                            <div class="col-sm-9">
                                <input class="form-control negara-select" type="text" placeholder="Negara" id="negara" name="negara" disabled value="@negara($data->negara_id)">
                            </div>
                        </div>

                        <div class="row mb-3" id="provinsi-form">
                            <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                            <div class="col-sm-9">
                                <input class="form-control provinsi-select" disabled value="@provinsi($data->provinsi_id)" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">
                            </div>
                        </div>

                        <div class="row mb-3" id="kota-form">
                            <label for="kota" class="col-sm-3 col-form-label">Kota/Kab</label>
                            <div class="col-sm-9">
                                <input class="form-control provinsi-select" disabled value="@kota($data->kota)" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control provinsi-select" disabled value="" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">{{ $data->alamat ?? '' }}</textarea>
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
                                    <input class="form-control provinsi-select" disabled value="{{ $data->nama_tdd ?? '' }}" type="text" placeholder="Provinsi" id="provinsi"
                                        name="provinsi">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jenis_identitas" class="col-sm-3 col-form-label">Jenis
                                    Identitas</label>
                                <div class="col">
                                    <input class="form-control provinsi-select" disabled value="{{ $data->jenis_identitas_tdd ?? '' }}" type="text" placeholder="Provinsi" id="provinsi"
                                        name="provinsi">
                                </div>
                                <div class="col">
                                    <input class="form-control provinsi-select" disabled value="{{ $data->nomor_identitas_tdd ?? '' }}" type="text" id="provinsi" name="provinsi">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-9">
                                    <input class="form-control provinsi-select" disabled value="{{ $data->jabatan_tdd ?? '' }}" type="text" placeholder="Provinsi" id="provinsi"
                                        name="provinsi">
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control provinsi-select" disabled value="" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">{{ $data->alamat_tdd ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                        <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kontak Person</label>
                        <hr class="mt-0 mb-3">

                        <div class="row mb-3">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input class="form-control provinsi-select" disabled value="{{ $data->nama_cp ?? '' }}" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control provinsi-select" disabled value="" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">{{ $data->alamat_cp ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                            <div class="col-sm-9">
                                <input class="form-control provinsi-select" disabled value="{{ $data->telepon_cp ?? '' }}" type="text" placeholder="Provinsi" id="provinsi" name="provinsi">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="text-start">
                    <h5>UPT DIPILIH</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table nowarp w-100 table-bordered nowarp" id="table-detail-upt">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama UPT</th>
                                <th>Tgl Pengajuan</th>
                                <th>Tgl Persetujuan</th>
                                <th>Status</th>
                                <th>Status Blokir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="text-start">
                    <h5>DOKUMEN PENDUKUNG</h5>
                </div>
            </div>
            <div class="card-body">
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
<div id="user-cabang-detail" data-id="{{ $data->id }}" data-status-import="{{ $data->status_import }}"></div>
<script src="{{ asset('assets/js/page/user/cabang/detail.js') }}"></script>
