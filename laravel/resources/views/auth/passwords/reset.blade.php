@extends ('layout')

@section ('content')
    <form class="form-signin text-center" method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <h1 class="h3 mb-3 font-weight-normal">{{ __('Reset Password') }}</h1>

        <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">
        @error('email')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

        <label for="password" class="sr-only">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus placeholder="{{ __('Password') }}">
        @error('password')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

         <label for="password-confirm" class="sr-only">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="form-control" name="password_password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">

        <button type="submit" class="mt-3 btn btn-lg btn-primary btn-block">{{ __('Reset Password') }}</button>

    </form>
@endsection
