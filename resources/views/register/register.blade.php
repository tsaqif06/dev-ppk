@extends('layouts.auth.master')
@push('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('title', 'Register')
@section('text', 'Registrasi PTK Online')
@section('content')
    <div class="p-3">
        <form method="POST" action="{{ route('register.new') }}" class="form-horizontal mt-3">
            @csrf
            {{-- <div class="d-flex justify-content-start"> --}}
            <div class="row">
                <div class="col-3">
                    <label for="pemohon">Pemohon</label>
                </div>
                <div class="col-3 me-5">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="pemohon" id="formRadios1" value="perusahaan">
                        <label class="form-check-label" for="formRadios1">
                            Perusahaan
                        </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pemohon" value="perorangan" id="formRadios2">
                        <label class="form-check-label" for="formRadios2">
                            Perorangan
                        </label>
                    </div>
                </div>
            </div>
            @error('pemohon')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            {{-- </div> --}}

            <div class="form-group mb-3 row d-none" id="perusahaan-select">
                <label for="perusahaan">Jenis Perusahaan</label>
                <div class="col-12">
                    <select id="jenis_perusahaan" type="text"
                        class="form-select @error('jenis_perusahaan') is-invalid @enderror" name="jenis_perusahaan">
                        <option value="">select item</option>
                        <option value="INDUK">Induk</option>
                        <option value="CABANG">Cabang</option>
                    </select>
                </div>
                @error('jenis_perusahaan')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 row">
                <label for="upt">UPT Karantina</label>
                <div class="col-12">
                    <select id="upt" disabled multiple type="text"
                        class="form-control @error('upt') is-invalid @enderror upt-select" name="upt[]"></select>
                </div>
                @error('upt')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 row">
                <label for="nama">Nama</label>
                <div class="col-12">
                    <input id="name" disabled type="text" class="form-control @error('name') is-invalid @enderror"
                        name="nama" value="{{ old('nama') }}" required autocomplete="name" autofocus>
                </div>
                @error('nama')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 row">
                <label for="email">Email</label>
                <div class="col-12">
                    <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email"
                        placeholder="example@email.com">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>




            <div class="form-group text-center row mt-2 pt-1">
                <div class="col-12">
                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Register</button>
                </div>
            </div>

            <div class="form-group mt-2 mb-0 row">
                <div class="col-12 mt-3 text-center">
                    <a href="{{ route('barantin.auth.index') }}" class="text-muted">Back to login</a>
                </div>
            </div>
        </form>
        <!-- end form -->
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endpush
@push('custom-js')
    <script src="{{ asset('assets/js/page/select.js') }}"></script>
    <script>
        UptSelect()
        $('.form-select').select2({
            placeholder: 'select item',
            minimumResultsForSearch: -1,
        });
        $('input[name="pemohon"]').change(function() {
            let val = $(this).val();
            let label = $('label[for="nama"]')
            if (val === 'perorangan') {
                label.html('Nama Pemohon');
                $('#perusahaan-select').addClass('d-none');
                $('#perusahaan-induk-select').addClass('d-none');
            } else {
                label.html('Nama Perusahaan');
                $('#perusahaan-select').removeClass('d-none');
            }
            $('.form-control').attr('disabled', false);
        });
        $('#jenis_perusahaan').on('change', function() {
            let val = $(this).val();
            console.log(val)
            if (val === 'CABANG') {
                $('#perusahaan-induk-select').removeClass('d-none');
                return
            }
            $('#perusahaan-induk-select').addClass('d-none');
            return
        });
    </script>
@endpush
