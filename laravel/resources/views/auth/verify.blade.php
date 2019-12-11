@extends ('layout')

@section ('content')
    <form class="form-signin text-center" method="POST" action="{{ route('verification.resend') }}">
        @csrf

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <h1 class="h3 mb-3 font-weight-normal">{{ __('Verify Your Email Address') }}</h1>

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},

        <button type="submit" class="mt-3 btn btn-lg btn-primary btn-block">{{ __('click here to request another') }}</button>

    </form>
@endsection
