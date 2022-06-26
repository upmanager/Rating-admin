@extends('auth.master')

@section('content')
<!-- /.login-logo -->
<style>
    .invalid-feedback {
        display: block
    }
</style>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('auth.Login') }}</p>
        @if (session('errors'))
        <span class="invalid-feedback" role="alert">
            <strong> {{session('errors')->first('error')}} </strong>
        </span>
        @endif
        <form action="{{route('login')}}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="{{__('auth.Email')}}"
                    required autocomplete="email" autofocus>
                <div class="input-group-append input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('auth.Password')}}" name="password" required
                    autocomplete="current-password">
                <div class="input-group-append input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="row">
                <div class="col-8">
                    {{-- <div class="icheck-primary">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember Me
                        </label>
                    </div> --}}
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('auth.Login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <hr>

        @if (Route::has('password.request'))
        <p class="mb-0">
            <a href="{{ route('password.request') }}">{{ __('auth.forgot-password') }}</a>
        </p>
        @endif
        @if (Route::has('register'))
        <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">{{ __('auth.create-account') }}</a>
        </p>
        @endif
    </div>
    <!-- /.login-card-body -->
</div>
@endsection