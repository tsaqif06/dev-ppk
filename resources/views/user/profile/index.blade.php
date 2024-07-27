@extends('layouts.vertical.master')
@section('title', 'Profile')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Profile</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                            <button class="btn btn-primary btn-sm" onclick="Changeprofile()">Ubah Profile</button>
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
                                        <input class="form-control" disabled value="{{ auth()->user()->barantin->nama_perusahaan }}" type="text" id="pemohon" name="pemohon">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">Jenis Perusahaan</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled value="{{ auth()->user()->barantin->jenis_perusahaan }}" type="text" id="pemohon" name="pemohon">
                                    </div>
                                </div>
                                {{-- @if (auth()->user()->role === 'cabang' || auth()->user()->role === 'induk')
                                    <div class="row mb-3">
                                        <label for="fax" class="col-sm-3 col-form-label">Nama Alias</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" disabled value="{{ auth()->user()->barantin->nama_alias_perusahaan }}" id="nomor_fax" name="nomor_fax">
                                        </div>
                                    </div>
                                @endif --}}
                                <div class="row mb-3">
                                    <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                                        Identitas</label>
                                    <div class="col">
                                        <input value="{{ auth()->user()->barantin->jenis_identitas }}" disabled class="form-control select-item" type="text">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="number" disabled value="{{ auth()->user()->barantin->nomor_identitas }}" id="nomor_identitas" name="nomor_identitas">
                                    </div>
                                </div>
                                @if (auth()->user()->role === 'cabang' || auth()->user()->role === 'induk')
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-3 col-form-label">NITKU</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" disabled value="{{ auth()->user()->barantin->nitku ?? '000000' }}" type="text" id="pemohon" name="pemohon">
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-3">
                                    <label for="upt" class="col-sm-3 col-form-label">Telephon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="telepon" disabled value="{{ auth()->user()->barantin->telepon }}" name="telepon"
                                            aria-describedby="inputGroupPrepend" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" disabled value="{{ auth()->user()->barantin->fax }}" id="nomor_fax" name="nomor_fax">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled value="{{ auth()->user()->barantin->email }}" type="email" id="email" name="email">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="status_import" class="col-sm-3 col-form-label">Status Import</label>
                                    <div class="col-sm-9">
                                        <input class="form-control select-item" disabled value="@statusimport(auth()->user()->barantin->status_import)">
                                        <div class="invalid-feedback" id="status_import-feedback"></div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <label for="status_import" class="col-sm-3 col-form-label">Lingkup Aktifitas</label>
                                    <div class="col-sm-9">
                                        <input class="form-control select-item" disabled value="@aktifitas(auth()->user()->barantin->lingkup_aktifitas)">
                                        <div class="invalid-feedback" id="status_import-feedback"></div>
                                    </div>
                                </div>

                                <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                                <label for="" class="form-label fw-bold h6 mt-0 mb-0">Alamat</label>
                                <hr class="mt-0 mb-3">
                                <div class="row mb-3">
                                    <label for="negara" class="col-sm-3 col-form-label">Negara</label>
                                    <div class="col-sm-9">
                                        <input class="form-control negara-select" type="text" id="negara" name="negara" disabled value="@negara(auth()->user()->barantin->negara_id)">
                                    </div>
                                </div>

                                <div class="row mb-3" id="provinsi-form">
                                    <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                                    <div class="col-sm-9">
                                        <input class="form-control provinsi-select" disabled value="@provinsi(auth()->user()->barantin->provinsi_id)" type="text">
                                    </div>
                                </div>

                                <div class="row mb-3" id="kota-form">
                                    <label for="kota" class="col-sm-3 col-form-label">Kota/Kab</label>
                                    <div class="col-sm-9">
                                        <input class="form-control provinsi-select" disabled value="@kota(auth()->user()->barantin->kota)" type="text">
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control provinsi-select" disabled>{{ auth()->user()->barantin->alamat }}</textarea>
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
                                            <input class="form-control provinsi-select" disabled value="{{ auth()->user()->barantin->nama_tdd }}" type="text">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="jenis_identitas" class="col-sm-3 col-form-label">Jenis
                                            Identitas</label>
                                        <div class="col">
                                            <input class="form-control provinsi-select" disabled value="{{ auth()->user()->barantin->jenis_identitas_tdd }}">
                                        </div>
                                        <div class="col">
                                            <input class="form-control provinsi-select" disabled value="{{ auth()->user()->barantin->nomor_identitas_tdd }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <input class="form-control provinsi-select" disabled value="{{ auth()->user()->barantin->jabatan_tdd }}" type="text">
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control provinsi-select" disabled>{{ auth()->user()->barantin->alamat_tdd }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
                                <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kontak Person</label>
                                <hr class="mt-0 mb-3">

                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input class="form-control provinsi-select" disabled value="{{ auth()->user()->barantin->nama_cp }}" type="text">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control provinsi-select" disabled>{{ auth()->user()->barantin->alamat_cp }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                                    <div class="col-sm-9">
                                        <input class="form-control provinsi-select" disabled value="{{ auth()->user()->barantin->telepon_cp }}">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
