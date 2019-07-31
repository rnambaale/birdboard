@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('login') }}" class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow">
    <h1 class="text-2xl font-normal mb-10 text-center">Login</h1>

    @csrf

    <div class="field mb-6">
        <label for="email" class="label text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

        <div class="control">
            <input
                id="email"
                type="email"
                class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                value="{{ old('email') }}"
                required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="field mb-6">
        <label for="password" class="label text-sm mb-2 block">Password</label>

        <div class="col-md-6">
            <input
                id="password"
                type="password"
                class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="field mb-6">
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-blue">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </div>
</form>

@endsection
