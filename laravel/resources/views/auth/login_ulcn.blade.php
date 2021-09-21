@extends ('layout')

@section ('content')
  <div class="form-signin text-center">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in:</h1>
  <p>
  <a href="{{ $oauth_url }}">
    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Sign in with ULCN') }}</button>
  </a>
  </p>

  @if (config('oauth.allow_password_login'))
    <p>
    <a href="{{ route('login.old_form') }}">
        <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Sign in with password') }}</button>
    </a>
    </p>
  @endif
  </div>
@endsection
