@extends('layouts.auth.master')
@section('title', 'verify email')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (isset($message_generate))
                            <div class="alert alert-success w-100 text-center" role="alert">
                                {!! $message_generate !!}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ url('/register/regenerate') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $generate->token }}">
                            <input type="hidden" name="user_id" value="{{ $generate->pre_register_id }}">
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
