<div id="basic-pills-wizard" class="twitter-bs-wizard">
    <ul class="twitter-bs-wizard-nav">
        <li class="nav-item">
            <a href="#seller-details" class="nav-link" data-toggle="tab">
                <span class="step-number">01</span>
                <span class="step-title">Register Pemohon</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#company-document" class="nav-link" data-toggle="tab">
                <span class="step-number">02</span>
                <span class="step-title">Kontak Person</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#bank-detail" class="nav-link" data-toggle="tab">
                <span class="step-number">03</span>
                <span class="step-title">Penandatangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#dokumen-pendukung" class="nav-link" data-toggle="tab">
                <span class="step-number">04</span>
                <span class="step-title">Dokumen Pendukung</span>
            </a>
        </li>
    </ul>
    <div class="tab-content twitter-bs-wizard-tab-content">
        <div class="tab-pane" id="seller-details">
            <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
            <label for="" class="form-label fw-bold h6 mt-0 mb-0">Register Pemohon</label>
            <hr class="mt-0 mb-3">
            <form class="row" id="form-register">
                @method('PATCH')
                <div class="col-md-6 col-sm-12">
                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Pemohon</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $data->barantin->preregister->pemohon }}"
                                type="text" id="" name="">
                            <div class="invalid-feedback" id="feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $data->barantin->perusahaan }}" type="text"
                                id="nama_perusahaan" name="nama_perusahaan">
                            <div class="invalid-feedback" id="nama_perusahaan-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                            Identitas</label>
                        <div class="col">
                            <select class="form-control select-item" type="text" placeholder="Jenis Identitas"
                                id="jenis_identitas" name="jenis_identitas">
                                <option value="">select item</option>
                                <option value="PASSPORT">PASSPORT</option>
                                <option value="KTP">KTP</option>
                                <option value="NPWP" selected>NPWP 16 DIGIT</option>
                            </select>
                            <div class="invalid-feedback" id="jenis_identitas-feedback"></div>
                        </div>
                        <div class="col">
                            <input class="form-control" type="number" placeholder="Nomor Identitas"
                                id="nomor_identitas" name="nomor_identitas"
                                value="{{ $data->barantin->nomor_identitas ?? '' }}" maxlength="16" pattern="\d*"
                                oninput="javascript: if (this.value.length >= this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <div class="invalid-feedback" id="nomor_identitas-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jenis_perusahaan" class="col-sm-3 col-form-label">Jenis Perusahaan</label>
                        <div class="col-sm-9">
                            <select class="form-control select-item" id="jenis_perusahaan" rows="3"
                                placeholder="Lingkup Akivitas" name="jenis_perusahaan">
                                <option value="PEMILIK BARANG">PEMILIK BARANG</option>
                                <option value="PPJK">PPJK</option>
                                <option value="EMKL">EMKL</option>
                                <option value="EMKU">EMKU</option>
                                <option value="LAINNYA">LAINNYA</option>
                            </select>
                            <div class="invalid-feedback" id="jenis_perusahaan-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lingkup_akivitas" class="col-sm-3 col-form-label">Lingkup Akivitas</label>
                        <div class="col-sm-9">
                            <select class="form-control select-item" id="lingkup_aktivitas" rows="3"
                                placeholder="Lingkup Akivitas" name="lingkup_aktivitas[]" multiple>
                                <option value="1">Import</option>
                                <option value="2">Domestik Masuk</option>
                                <option value="3">Export</option>
                                <option value="4">Domestik Keluar</option>
                            </select>
                            <div class="invalid-feedback" id="lingkup_aktivitas-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="upt" class="col-sm-3 col-form-label">Telepon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                aria-describedby="inputGroupPrepend" required
                                value="{{ $data->barantin->telepon ?? '' }}">
                            <div class="invalid-feedback" id="telepon-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row mb-3">
                        <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" placeholder="Fax" id="fax"
                                name="fax" value="{{ $data->barantin->fax ?? '' }}">
                            <div class="invalid-feedback" id="fax-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $data->barantin->preregister->email }}"
                                type="email" placeholder="Email" id="email" name="email">
                            <div class="invalid-feedback" id="email-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="status_import" class="col-sm-3 col-form-label">Status Import</label>
                        <div class="col-sm-9">
                            <select class="form-select select-item" id="status_import" name="status_import">
                                <option value="">select item</option>
                                <option value="25">Importir Umum</option>
                                <option value="26">Importir Produsen</option>
                                <option value="27">Importir Terdaftar</option>
                                <option value="28">Agen Tunggal</option>
                                <option value="29">BULOG</option>
                                <option value="30">PERTAMINA</option>
                                <option value="31">DAHANA</option>
                                <option value="32">IPTN</option>
                            </select>
                            <div class="invalid-feedback" id="status_import-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3" id="provinsi-form">
                        <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                        <div class="col-sm-9">
                            <select class="form-control provinsi-select" type="text" placeholder="Provinsi"
                                id="provinsi" name="provinsi"></select>
                            <div class="invalid-feedback" id="provinsi-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3" id="kota-form">
                        <label for="kota" class="col-sm-3 col-form-label">Kota/Kab</label>
                        <div class="col-sm-9">
                            <select class="form-control kota-select" type="text" placeholder="Kota"
                                id="kota" name="kota"></select>
                            <div class="invalid-feedback" id="kota-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" type="text" placeholder="Alamat" id="alamat"rows="4" name="alamat">{{ $data->barantin->alamat ?? '' }}</textarea>
                            <div class="invalid-feedback" id="alamat-feedback"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="company-document">
            <div>
                <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kontak Person</label>
                <hr class="mt-0 mb-3">
                <form id="form-cp">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nama" id="nama_cp"
                                name="nama_cp" value="{{ $data->barantin->nama_cp ?? '' }}">
                            <div class="invalid-feedback" id="nama_cp-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat" id="alamat_cp"
                                name="alamat_cp" value="{{ $data->barantin->alamat_cp ?? '' }}">
                            <div class="invalid-feedback" id="alamat_cp-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="tel" placeholder="Telepon" id="telepon_cp"
                                name="telepon_cp" value="{{ $data->barantin->telepon_cp ?? '' }}">
                            <div class="invalid-feedback" id="telepon_cp-feedback"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="bank-detail">
            <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
            <label for="" class="form-label fw-bold h6 mt-0 mb-0">Penandatangan</label>
            <hr class="mt-0 mb-3">
            <div>
                <form id="form-penandatangan">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nama" id="nama_tdd"
                                name="nama_tdd" value="{{ $data->barantin->nama_tdd ?? '' }}">
                            <div class="invalid-feedback" id="nama_tdd-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jenis_identitas" class="col-sm-2 col-form-label">Jenis Identitas</label>
                        <div class="col">
                            <select class="form-control select-item" type="text" placeholder="Jenis Identitas"
                                id="jenis_identitas_tdd" name="jenis_identitas_tdd">
                                <option value="">select item</option>
                                <option value="PASSPORT">PASSPORT</option>
                                <option value="KTP">KTP</option>
                                <option value="NPWP" selected>NPWP 16 DIGIT</option>
                            </select>
                            <div class="invalid-feedback" id="jenis_identitas_tdd-feedback"></div>
                        </div>
                        <div class="col">
                            <input class="form-control" type="number" placeholder="Nomer Identitas"
                                id="nomor_identitas_tdd" name="nomor_identitas_tdd"
                                value="{{ $data->barantin->nomor_identitas_tdd ?? '' }}" maxlength="16"
                                pattern="\d*"
                                oninput="javascript: if (this.value.length >= this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <div class="invalid-feedback" id="nomor_identitas_tdd-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Jabatan" id="jabatan_tdd"
                                name="jabatan_tdd" value="{{ $data->barantin->jabatan_tdd ?? '' }}">
                            <div class="invalid-feedback" id="jabatan_tdd-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat" id="alamat_tdd"
                                name="alamat_tdd" value="{{ $data->barantin->alamat_tdd ?? '' }}">
                            <div class="invalid-feedback" id="alamat_tdd-feedback"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-pane" id="dokumen-pendukung">
            <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
            <label for="" class="form-label fw-bold h6 mt-0 mb-0">Dokumen Pendukung</label>
            <hr class="mt-0 mb-3">
            <div>
                <form class="row" id="form-pendukung" novalidate>
                    <div class="col-md-4 mb-3">
                        <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                        <select type="text" class="form-select form-control-dokumen" id="jenis_dokumen"
                            name="jenis_dokumen">
                            <option value="">select item</option>
                            <option value="KTP">KTP</option>
                            <option value="PASSPORT">PASSPORT</option>
                            <option value="NPWP" selected>NPWP 16 DIGIT</option>
                        </select>
                        <div class="invalid-feedback" id="jenis_dokumen-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nomer_dokumen" class="form-label">Nomer Dokumen</label>
                        <input type="number" class="form-control form-control-dokumen" id="nomer_dokumen"
                            name="nomer_dokumen" maxlength="16" pattern="\d*"
                            oninput="javascript: if (this.value.length >= this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                        <div class="invalid-feedback" id="nomer_dokumen-feedback"></div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_terbit" class="form-label">Tanggal terbit</label>
                        <input type="date" class="form-control form-control-dokumen" id="tanggal_terbit"
                            name="tanggal_terbit">
                        <div class="invalid-feedback" id="tanggal_terbit-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Upload Dokumen</label>
                        <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" />
                        <div class="invalid-feedback" id="file_dokumen-feedback"></div>
                    </div>
                </form>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-info mb-3" id="button-pendukung">tambah</button>
                </div>
                <div class="row mb-5">
                    <div class="table-responsive">
                        <table id="datatable-dokumen-pendukung" data-id="{{ $data->barantin->id }}"
                            class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Dokumen</th>
                                    <th>No Dokumen</th>
                                    <th>Tanggal Terbit</th>
                                    <th>Dokumen</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <ul class="pager wizard twitter-bs-wizard-pager-link">
        <li class="previous"><a href="javascript: void(0);">Previous</a></li>
        <li class="next"><a href="javascript: void(0);">Next</a></li>
        <li class="submit-form d-none"><button class="btn btn-success" id="button-submit"
                href="javascript: void(0);">Submit</button>
        </li>
    </ul>
</div>
<script src="{{ asset('assets/js/pages/form-wizard.update.js') }}"></script>
<script src="{{ asset('assets/js/page/form/update/perorangan.js') }}"></script>
<script>
    UptSelect('{{ $data->barantin->upt_id ?? null }}', '{{ $data->barantin->preregister->id ?? null }}')
    NegaraSelect('{{ $data->barantin->negara_id ?? 99 }}')
    ProvinsiSelect('{{ $data->barantin->provinsi_id ?? null }}')
    KotaSelect('{{ $data->barantin->kota ?? null }}')
    $('#status_import').val('{{ $data->barantin->status_import ?? '' }}').trigger('change')
    $('#jenis_perusahaan').val('{{ $data->barantin->jenis_perusahaan ?? '' }}').trigger('change')
    $('#jenis_identitas_tdd').val('{{ $data->barantin->jenis_identitas_tdd ?? '' }}').trigger('change')
    $('#jenis_identitas').val('{{ $data->barantin->jenis_identitas ?? '' }}').trigger('change')

    let lingkup = '{{ $data->barantin->lingkup_aktifitas }}'
    let lingkupArray = lingkup.split(',');
    lingkupArray = lingkupArray.map(function(value) {
        return value.trim(); // Trims any extra whitespace
    });
    $('#lingkup_aktivitas').val(lingkupArray).trigger('change');
</script>
