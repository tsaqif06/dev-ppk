@extends('layouts.vertical.master')
@section('title', 'Cabang')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/dropify/dist/dropify.min.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="container-fluid">
        <div id="page-grid"></div>
        <div id="page-index">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">CABANG</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                                <li class="breadcrumb-item active">Cabang</li>
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
                                <button class="btn btn-primary btn-sm" onclick="CreateCabang('{{ route('barantin.cabang.create') }}')">tambah cabang</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="user-cabang-datatable" class="table table-bordered dt-responsive nowrap w-100" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Opsi</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Jenis Identitas Induk</th>
                                            <th>Nomor Identitas Induk</th>
                                            <th>NITKU</th>
                                            <th>Telepon</th>
                                            <th>Fax</th>
                                            <th>Email</th>
                                            <th>Negara</th>
                                            <th>Provinsi</th>
                                            <th>Kota/Kab</th>
                                            <th>Alamat</th>
                                            <th>Status Import</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('assets/libs/dropify/dist/dropify.min.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/imask/imask.init.js') }}"></script>
@endpush
@push('custom-js')
    <script src="{{ asset('assets/js/page/select.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatable/user/cabang.js') }}"></script>
@endpush
