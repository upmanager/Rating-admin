@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.email-verify') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.email-verify-sent') }}
                        </div>
                    @endif

                    {{ __('auth.email-verify-comments') }}
                    {{ __('auth.no-received-email') }}, <a href="{{ route('verification.resend') }}">{{ __('auth.request-another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
