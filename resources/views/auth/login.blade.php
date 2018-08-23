@extends('layouts.auth')

@section('content')

    <div class="card p-4">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                <h1>{{ __('Login') }}</h1>
                <p class="text-muted">Sign In to your account</p>
                @csrf
                <div role="group" class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-user"></i></div>
                    </div>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                    @endif
                </div>
                <div role="group" class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-lock"></i></div>
                    </div>
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                           required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit"
                                class="btn px-4 btn-primary">{{ __('Login') }}</button>
                    </div>
                    <div class="text-right col-6">
                        <a class="btn px-0 btn-link"
                           href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
