@extends('layouts.auth.master')
@section('title', 'Login Admin')
@section('text', 'Admin Sign in')
@section('content')
    <div class="p-3">
        <form class="form-horizontal mt-3" action="{{ route('admin.auth.login') }}" method="POST">
            @csrf
            <div class="form-group mb-3 row">
                <label for="email">Username</label>
                <div class="col-12">
                    <input id="email" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required autocomplete="username" autofocus
                        placeholder="username">
                </div>
                @error('username')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 row">
                <label for="password">Password</label>
                <div class="col-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder="password">
                </div>
            </div>
            <div class="form-group mb-3 text-center row mt-3 pt-1">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Log
                        In</button>
                </div>
            </div>
        </form>
    </div>
@endsection
