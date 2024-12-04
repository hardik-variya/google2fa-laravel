@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        {{-- Display success message --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Display error message --}}
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <p>{{ __('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                        </p>
                        @if ($user->google2fa_secret == null)
                            <div class="col-lg-12 text-center">
                                <a href="{{ route('generate2fa.secret') }}" class="btn btn-primary">
                                    {{ __(' Generate Secret Key to Enable 2FA') }}
                                </a>
                            </div>
                        @elseif($user->google2fa_enable == 0 && $user->google2fa_secret != null)
                            1. {{ __('Install “Google Authentication App” on your') }} <a
                                href="https://apps.apple.com/us/app/google-authenticator/id388497605" target="_black">
                                {{ __('IOS') }}</a> {{ __('or') }} <a
                                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                                target="_black">{{ __('Android phone.') }}</a><br />
                            2. {{ __('Open the Google Authentication App and scan the below QR code.') }}<br />
                            @php
                                $f = finfo_open();
                                $mime_type = finfo_buffer($f, $google2fa_url, FILEINFO_MIME_TYPE);
                            @endphp
                            @if ($mime_type == 'text/plain')
                                <img src="{{ $google2fa_url }}" alt="">
                            @else
                                {!! $google2fa_url !!}
                            @endif
                            <br /><br />
                            {{ __('Alternatively, you can use the code:') }}
                            <code>{{ $user->google2fa_secret }}</code>.<br />
                            3. {{ __('Enter the 6-digit Google Authentication code from the app') }}<br /><br />
                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="secret" class="col-form-label">{{ __('Authenticator Code') }}</label>
                                    <input id="secret" type="password" class="form-control" name="secret"
                                        required="required">
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        {{ __('Enable 2FA') }}
                                    </button>
                                </div>
                            </form>
                        @elseif($user->google2fa_enable == 1 && $user->google2fa_secret != null)
                            <div class="alert alert-success">
                                {{ __('2FA is currently') }} <strong>{{ __('Enabled') }}</strong>
                                {{ __('on your account.') }}
                            </div>
                            <p>{{ __('If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.') }}
                            </p>
                            <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password"
                                        class="col-form-label">{{ __('Current Password') }}</label>
                                    <input id="current-password" type="password" class="form-control"
                                        name="current-password" required="required">
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('current-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        {{ __('Disable 2FA') }}
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
