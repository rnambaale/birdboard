@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('register') }}" class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow">
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Register</h1>

        <div class="field mb-6">
            <label for="name" class="label text-sm mb-2 block">{{ __('Name') }}</label>

            <div class="control">
                <input
                    id="name" type="text"
                    class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                    value="{{ old('name') }}"
                    required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="field mb-6">
            <label for="email" class="label text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

            <div class="control">
                <input
                    id="email"
                    type="email"
                    class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="field mb-6">
            <label for="password" class="label text-sm mb-2 block">{{ __('Password') }}</label>

            <div class="control">
                <input
                    id="password"
                    type="password"
                    class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="field mb-6">
            <label for="password-confirm" class="label text-sm mb-2 block">{{ __('Confirm Password') }}</label>

            <div class="control">
                <input
                    id="password-confirm"
                    type="password"
                    class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full"
                    name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="btn btn-blue">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </form>

@endsection
