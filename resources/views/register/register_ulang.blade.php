@extends('layouts.auth.master')
@section('title', 'Register')
@section('text', 'Regiter Baru')
@section('content')
    <div class="p-3">
        <form method="POST" action="{{ route('register.ulang') }}" class="form-horizontal mt-3">
            @csrf
            <div class="row">
                <div class="col-3">
                    <label for="pemohon">Pemohon :</label>
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
            <div class="form-group mb-3 row">
                <label for="nama">Username</label>
                <div class="col-12">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                </div>
                @error('username')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 row">
                <label for="email">Email</label>
                <div class="col-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
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
