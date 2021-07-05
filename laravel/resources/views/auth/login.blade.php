@extends ('layout')

@section ('content')
    <form class="form-signin text-center" method="POST" action="{{ route('login') }}">
        @csrf

        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

        <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" required autofocus autocomplete="email" placeholder="{{ __('E-Mail Address') }}">
        @error('email')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

        <label for="password" class="sr-only">{{ __('Password') }}</label>
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
        @error('password')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} value="remember"> {{ __('Remember Me') }}
            </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Sign in') }}</button>

        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        @endif
    </form>
@endsection
