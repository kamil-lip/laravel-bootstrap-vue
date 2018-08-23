@extends('layouts.auth')

@section('content')
    <div class="card p-4">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                <h1>{{ __('Reset Password') }}</h1>
                @csrf
                <div role="group" class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i>@</i></div>
                    </div>
                    <input placeholder="E-mail address" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit"
                                class="btn px-4 btn-primary">{{ __('Send Password Reset Link') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
