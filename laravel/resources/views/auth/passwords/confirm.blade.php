@extends ('layout')

@section ('content')
    <form class="form-signin text-center" method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <h1 class="h3 mb-3 font-weight-normal">{{ __('Confirm Password') }}</h1>

        <label for="password" class="sr-only">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
        @error('password')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

        <button type="submit" class="mt-3 btn btn-lg btn-primary btn-block">{{ __('Confirm Password') }}</button>

        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        @endif
        
    </form>
@endsection
