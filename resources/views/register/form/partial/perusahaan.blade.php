<div id="basic-pills-wizard" class="twitter-bs-wizard">
    <ul class="twitter-bs-wizard-nav">
        <li class="nav-item">
            <a href="#seller-details" class="nav-link" data-toggle="tab">
                <span class="step-number">01</span>
                <span class="step-title">Data Pemohon</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#kegiatan-usaha" class="nav-link" data-toggle="tab">
                <span class="step-number">02</span>
                <span class="step-title">Kegiatan Usaha</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#sarana-prasarana" class="nav-link" data-toggle="tab">
                <span class="step-number">03</span>
                <span class="step-title">Sarana Prasarana</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#dokumen-pendukung" class="nav-link" data-toggle="tab">
                <span class="step-number">04</span>
                <span class="step-title">Dokumen Pendukung</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#ketentuan-form" class="nav-link" data-toggle="tab">
                <span class="step-number">05</span>
                <span class="step-title">Ketentuan</span>
            </a>
        </li>
    </ul>
    <div class="tab-content twitter-bs-wizard-tab-content">
        <div class="tab-pane" id="seller-details">
            <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
            <label for="" class="form-label fw-bold h6 mt-0 mb-0">Data Pemohon</label>
            <hr class="mt-0 mb-3">

            <form class="row" id="form-register">
                <div class="col-md-6 col-sm-12">
                    <div class="row mb-3">
                        <label for="pemohon" class="col-sm-3 col-form-label">Pemohon</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $register->pemohon }}" type="text"
                                id="" name="">
                            <div class="invalid-feedback" id="feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="identifikasi_perusahaan" class="col-sm-3 col-form-label">Identifikasi
                            Perusahaan</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $register->jenis_perusahaan }}"
                                name="identifikasi_perusahaan" id="identifikasi_perusahaan" type="text"
                                id="" name="">
                            <div class="invalid-feedback" id="identifikasi_perusahaan-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kategori_perusahaan" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                        <div class="col">
                            <select id="kategori_perusahaan" class="form-select" name="kategori_perusahaan">
                                <option value="PT" {{ $kategori_perusahaan == 'PT' ? 'selected' : '' }}>PT</option>
                                <option value="CV" {{ $kategori_perusahaan == 'CV' ? 'selected' : '' }}>CV</option>
                                <option value="UD" {{ $kategori_perusahaan == 'UD' ? 'selected' : '' }}>UD</option>
                            </select>
                        </div>
                        <div class="col">
                            <input class="form-control" value="{{ $nama_perusahaan }}" type="text"
                                id="nama_perusahaan" name="nama_perusahaan">
                            <div class="invalid-feedback" id="nama_perusahaan-feedback"></div>
                        </div>
                    </div>

                    {{-- <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $register->nama }}" type="text"
                                id="nama_perusahaan" name="nama_perusahaan">
                            <div class="invalid-feedback" id="nama_perusahaan-feedback"></div>
                        </div>
                    </div> --}}

                    <div class="row mb-3">
                        <label for="jenis_identitas" class="col-md-3 col-form-label">Jenis Identitas</label>
                        <div class="col">
                            <select class="form-control select-item" type="text" placeholder="Jenis Identitas"
                                id="jenis_identitas" name="jenis_identitas">
                                <option value="">select item</option>
                                <option value="NPWP" selected>NPWP 16 DIGIT</option>
                            </select>
                            <div class="invalid-feedback" id="jenis_identitas-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nomor_identitas" class="col-md-3 col-form-label">Nomor Identitas</label>
                        <div class="col">
                            <input class="form-control" type="number" placeholder="Nomor Identitas"
                                id="nomor_identitas" name="nomor_identitas"
                                value="{{ $baratan->nomor_identitas ?? '' }}" maxlength="16" pattern="\d*"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                onchange="document.getElementById('nomer_dokumen').value = this.value;">
                            <div class="invalid-feedback" id="nomor_identitas-feedback"></div>
                        </div>
                        <div class="col">
                            <input class="form-control" type="number" id="nitku" placeholder="NITKU"
                                name="nitku" maxlength="6"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <div class="invalid-feedback" id="nitku-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="upt" class="col-sm-3 col-form-label">Telephon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                aria-describedby="inputGroupPrepend" value="{{ $baratan->telepon ?? '' }}">
                            <div class="invalid-feedback" id="telepon-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Permohonan Registrasi ke UPT</label>
                        <div class="col-sm-9">
                            <select class="form-control upt-select" id="upt" multiple name="upt[]"></select>
                            <div class="invalid-feedback" id="upt-feedback"></div>
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

                    <div class="row mb-3 d-none" id="nama_alias">
                        <label for="email" class="col-sm-3 col-form-label">Nama Alias Perusahaan</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="" type="text" id="nama_alias_perusahaan"
                                name="nama_alias_perusahaan">
                            <div class="invalid-feedback" id="nama_alias_perusahaan-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row mb-3">
                        <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" placeholder="Fax" id="fax"
                                name="fax" value="{{ $baratan->fax ?? '' }}">
                            <div class="invalid-feedback" id="fax-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $register->email }}" type="email"
                                placeholder="Email" id="email" name="email">
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
                            <textarea class="form-control" type="text" placeholder="Alamat" id="alamat"rows="4" name="alamat">{{ $baratan->alamat ?? '' }}</textarea>
                            <div class="invalid-feedback" id="alamat-feedback"></div>
                        </div>
                    </div>
                </div>

                <div>
                    <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                    <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kontak Person</label>
                    <hr class="mt-0 mb-3">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nama" id="nama_cp"
                                name="nama_cp" value="{{ $baratan->nama_cp ?? '' }}">
                            <div class="invalid-feedback" id="nama_cp-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat" id="alamat_cp"
                                name="alamat_cp" value="{{ $baratan->alamat_cp ?? '' }}">
                            <div class="invalid-feedback" id="alamat_cp-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="tel" placeholder="Telepon" id="telepon_cp"
                                name="telepon_cp" value="{{ $baratan->telepon_cp ?? '' }}">
                            <div class="invalid-feedback" id="telepon_cp-feedback"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                    <label for="" class="form-label fw-bold h6 mt-0 mb-0">Penandatangan</label>
                    <hr class="mt-0 mb-3">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nama" id="nama_tdd"
                                name="nama_tdd" value="{{ $baratan->nama_tdd ?? '' }}">
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
                                value="{{ $baratan->nomor_identitas_tdd ?? '' }}" maxlength="16" pattern="\d*"
                                oninput="javascript: if (this.value.length >= this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <div class="invalid-feedback" id="nomor_identitas_tdd-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Jabatan" id="jabatan_tdd"
                                name="jabatan_tdd" value="{{ $baratan->jabatan_tdd ?? '' }}">
                            <div class="invalid-feedback" id="jabatan_tdd-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat" id="alamat_tdd"
                                name="alamat_tdd" value="{{ $baratan->alamat_tdd ?? '' }}">
                            <div class="invalid-feedback" id="alamat_tdd-feedback"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane" id="kegiatan-usaha">
            <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
            <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kegiatan Usaha</label>
            <hr class="mt-0 mb-3">
            <form class="row" id="form-kegiatan">
                <div class="form-group mb-3" style="display: flex; flex-direction: column;">
                    <label for="rerata-frekuensi">Rerata frekuensi kegiatan dalam setahun</label>
                    <input type="number" class="form-control" id="rerata-frekuensi" name="rerata_frekuensi"
                        placeholder="... kali">
                </div>
                <h6>Hewan</h6>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="hewan-hidup-checkbox"
                        onchange="toggleInput('hewan-hidup-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="hewan-hidup-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Hidup</label>
                    <input type="text" class="form-control" id="hewan-hidup-input" name="hewan_hidup_keterangan"
                        disabled style="flex: 1; min-width: 150px;">
                </div>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="hewan-produk-checkbox"
                        onchange="toggleInput('hewan-produk-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="hewan-produk-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Produk</label>
                    <input type="text" class="form-control" id="hewan-produk-input"
                        name="hewan_produk_keterangan" disabled style="flex: 1; min-width: 150px;">
                </div>
                <h6>Ikan / Hewan Air</h6>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="ikan-hidup-checkbox"
                        onchange="toggleInput('ikan-hidup-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="ikan-hidup-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Hidup</label>
                    <input type="text" class="form-control" id="ikan-hidup-input" name="ikan_hidup_keterangan"
                        disabled style="flex: 1; min-width: 150px;">
                </div>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="ikan-segar-checkbox"
                        onchange="toggleInput('ikan-segar-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="ikan-segar-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Segar/Beku</label>
                    <input type="text" class="form-control" id="ikan-segar-input" name="ikan_segar_keterangan"
                        disabled style="flex: 1; min-width: 150px;">
                </div>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="ikan-produk-checkbox"
                        onchange="toggleInput('ikan-produk-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="ikan-produk-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Produk</label>
                    <input type="text" class="form-control" id="ikan-produk-input" name="ikan_produk_keterangan"
                        disabled style="flex: 1; min-width: 150px;">
                </div>
                <h6>Tumbuhan</h6>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="tumbuhan-benih-checkbox"
                        onchange="toggleInput('tumbuhan-benih-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="tumbuhan-benih-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Benih</label>
                    <input type="text" class="form-control" id="tumbuhan-benih-input"
                        name="tumbuhan_benih_keterangan" disabled style="flex: 1; min-width: 150px;">
                </div>
                <div class="form-group mb-3" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <input class="form-check-input" type="checkbox" id="tumbuhan-nonbenih-checkbox"
                        onchange="toggleInput('tumbuhan-nonbenih-input', this)" style="margin-right: 10px;">
                    <label class="form-check-label" for="tumbuhan-nonbenih-checkbox"
                        style="margin-right: 10px; min-width: 80px;">Non Benih</label>
                    <input type="text" class="form-control" id="tumbuhan-nonbenih-input"
                        name="tumbuhan_nonbenih_keterangan" disabled style="flex: 1; min-width: 150px;">
                </div>
            </form>
        </div>

        <script>
            function toggleInput(inputId, checkbox) {
                const input = document.getElementById(inputId);
                input.disabled = !checkbox.checked;
            }
        </script>

        <div class="tab-pane" id="sarana-prasarana">
            <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
            <label for="" class="form-label fw-bold h6 mt-0 mb-0">Sarana Prasarana</label>
            <hr class="mt-0 mb-3">
            <form class="row" id="form-sarpras">
                <div class="form-group">
                    <label>Memiliki tempat Tindakan karantina</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tindakan_karantina" id="karantina-ya"
                            value="Ya">
                        <label class="form-check-label" for="karantina-ya">
                            Ya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tindakan_karantina"
                            id="karantina-tidak" value="Tidak">
                        <label class="form-check-label" for="karantina-tidak">
                            Tidak
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status-kepemilikan">Status kepemilikan</label>
                    <select class="form-control" id="status-kepemilikan" name="status_kepemilikan">
                        <option value="Milik Sendiri">Milik Sendiri</option>
                        <option value="Sewa">Sewa</option>
                    </select>
                </div>
                <div class="form-group" id="nomor-registrasi-group" style="display: none;">
                    <label for="nomor-registrasi">Nomor Registrasi/SK Instalasi Karantina</label>
                    <input type="text" class="form-control" id="nomor-registrasi" name="nomor_registrasi">
                </div>
            </form>
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
                            <option value="NPWP" selected>NPWP 16 DIGIT</option>
                            <option value="NITKU">NITKU</option>
                            <option value="SIUP">SIUP / IUI / IUT / SIUP JPT</option>
                            <option value="surat_keterangan_domisili">Surat Keterangan Domisili</option>
                            <option value="KTP">KTP</option>
                            <option value="NIB">NIB</option>
                            <option value="TDP">TDP / TDUP / TDI</option>
                            <option value="angka_pengenal_importir">Angka Pengenal Importir</option>
                        </select>
                        <div class="invalid-feedback" id="jenis_dokumen-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nomer_dokumen" class="form-label">Nomer Dokumen</label>
                        <input type="number" class="form-control form-control-dokumen" id="nomer_dokumen"
                            name="nomer_dokumen" maxlength="16" oninput="this.value = this.value.slice(0, 16);">
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
                    <button class="btn btn-info mb-3" id="button-pendukung">Tambah</button>
                </div>
                <div class="row mb-5">
                    <div class="table-responsive">
                        <table id="datatable-dokumen-pendukung" data-pre-register="{{ $register->id }}"
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

        <div class="tab-pane" id="ketentuan-form">
            <div>
                <p class="text-justify">
                    Dengan melakukan registrasi, Anda menyatakan bahwa semua data yang Anda input adalah benar, akurat,
                    dan lengkap. Anda bertanggung jawab untuk menjaga keakuratan data ini dan segera memperbarui
                    informasi yang diperlukan. Anda juga setuju untuk menjaga kerahasiaan informasi akun yang diberikan
                    kepada Anda, termasuk nama pengguna dan kata sandi. Anda bertanggung jawab penuh atas semua
                    aktivitas yang terjadi dalam akun Anda. Jika Anda mencurigai adanya penggunaan yang tidak sah atau
                    pelanggaran keamanan, Anda wajib segera memberitahukan kepada kami. Kami tidak bertanggung jawab
                    atas kerugian atau kerusakan yang timbul akibat kelalaian Anda dalam menjaga kerahasiaan akun.
                </p>
            </div>
            <form class="row" id="form-ketentuan">
                <div class="col-3 me-5">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="ketentuan" id="ketentuan"
                            value="ketentuan">
                        <label class="form-check-label" for="ketentuan">
                            Ya, Saya Setuju
                        </label>
                        <div class="invalid-feedback" id="ketentuan-feedback"></div>
                    </div>
                </div>
            </form>
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
<script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
<script src="{{ asset('assets/js/page/form/perusahaan.js') }}"></script>
<script>
    UptSelect('{{ $baratan->upt_id ?? null }}', '{{ $register->id ?? null }}')
    NegaraSelect('{{ $baratan->negara_id ?? 99 }}')
    ProvinsiSelect('{{ $baratan->provinsi_id ?? null }}')
    KotaSelect('{{ $baratan->kota ?? null }}')
    $('#status_import').val('{{ $baratan->status_import ?? '' }}').trigger('change')
</script>
