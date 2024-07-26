@extends('layouts.horizontal.master')
@section('title', 'Register')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/dropify/dist/dropify.min.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="container-fluid">
        <div id="page-grid"></div>
        <div id="page-index">
            <div class="row mb-4">
                <div class="d-flex align-items-end justify-content-end">
                    {{-- <div class="col-md-3 col-sm-12"> --}}
                    <a class="btn btn-primary btn-sm" href="{{ route('register.status') }}" target="_blank">
                        Cek Status Registrasi
                    </a>
                    {{-- </div> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title my-2">Register Data</h4>
                        </div>
                        <div class="card-body" id="form-data-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center d-none my-5" id="spinner">
                <div class="spinner-border " style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection

@push('js')
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('assets/libs/dropify/dist/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/imask/imask.init.js') }}"></script>
@endpush
@push('custom-js')
    <script src="{{ asset('assets/js/page/select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#spinner').clone().removeClass('d-none').appendTo('#form-data-input');
            $('#form-data-input').load('/register/form/' +
                '{{ $id }}?baratan_id={{ isset($baratan) ?? null }}');
        })
    </script>
@endpush
