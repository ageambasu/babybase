@extends ('layout')

@section ('content')
    <form class="form-signin text-center" method="POST" action="{{ route('password.email') }}">
        @csrf

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h1 class="h3 mb-3 font-weight-normal">{{ __('Reset Password') }}</h1>

        <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">
        @error('email')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

        <button type="submit" class="mt-3 btn btn-lg btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
    </form>
@endsection
