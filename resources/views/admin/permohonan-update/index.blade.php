@extends('layouts.vertical.master')
@section('title', 'Permohonan Update')
@push('css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div id="page-grid"></div>
        <div id="page-index">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Permohonan Update</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">Permohonan Update</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="permohonan-update-datatable" class="table table-bordered dt-responsive nowrap w-100" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Pemohon</th>
                                            <th>Perusahaan Pemohon</th>
                                            <th>Jenis Perusahaan</th>
                                            <th>Keterangan</th>
                                            <th>Persetujuan</th>
                                            <th>Status Update</th>
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
    </div>

@endsection
@push('js')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush
@push('custom-js')
    <script src="{{ asset('assets/js/page/datatable/permohonan-update.js') }}"></script>
@endpush