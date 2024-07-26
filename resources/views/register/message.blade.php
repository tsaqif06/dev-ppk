@extends('layouts.auth.master')
@section('title', 'message')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('message_token'))
                    <div class="alert alert-danger w-100 text-center" role="alert">
                        {!! session('message_token') !!}
                    </div>
                @endif
                @if (session('message_waiting'))
                    <div class="alert alert-success w-100 text-center" role="alert">
                        {!! session('message_waiting') !!}
                    </div>
                @endif
                @if (session('message_cancel'))
                    <div class="alert alert-warning w-100 text-center" role="alert">
                        {!! session('message_cancel') !!}
                    </div>
                @endif

            </div>
            <div class="col-12 mt-3 text-center">
                <a href="{{ route('barantin.auth.index') }}" class="text-muted">Back to login</a>
            </div>
        </div>
    </div>
@endsection
