@extends('layouts.horizontal.master')
@section('title', 'Status Register')
@push('css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Status Register</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="status-datatable" class="table table-bordered dt-responsive nowrap w-100" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Pemohon</th>
                                        <th>Perusahaan</th>
                                        <th>Nama Pemohon</th>
                                        <th>Jabatan</th>
                                        <th>Kota</th>
                                        <th>Kantor Karangtina</th>
                                        <th>Tgl Register</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
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
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
@endpush
@push('custom-js')
    <script src="{{ asset('assets/js/page/datatable/status.js') }}"></script>
@endpush
