@extends('layouts.vertical.master')
@section('title', 'Log')
@push('css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Master UPT</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Master UPT</li>
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
                            <button class="btn btn-primary btn-sm w-"
                                onclick="modal('Tambah UPT','modal-xl','static','{{ route('admin.master-upt.create') }}')">tambah
                                upt</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="masterupt-datatable" class="table table-bordered dt-responsive nowrap w-100"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Satpel</th>
                                        <th>Kode UTP</th>
                                        <th>Nama</th>
                                        <th>Nama (English)</th>
                                        <th>Wilayah Kerja</th>
                                        <th>Nama Satpel</th>
                                        <th>Kota</th>
                                        <th>Kode Pelabuhan</th>
                                        <th>Tembusan</th>
                                        <th>Otoritas Pelabuhan</th>
                                        <th>Syah Bandar Pelabuhan</th>
                                        <th>Kepala Kantor Bea Cukai</th>
                                        <th>Nama Pengelola</th>
                                        <th>Stat PPKOL</th>
                                        <th>Stat INSW</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>

@endsection
@push('js')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush
@push('custom-js')
    <script src="{{ asset('assets/js/page/datatable/masterupt.js') }}"></script>
@endpush
