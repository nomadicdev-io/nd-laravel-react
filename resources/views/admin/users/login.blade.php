@extends('admin.layouts.login_master')
@section('metatags')
    <meta name="description" content="{{ @$websiteSettings->site_meta_description }}" />
    <meta name="keywords" content="{{ @$websiteSettings->site_meta_keyword }}" />
    <meta name="author" content="{{ @$websiteSettings->site_meta_title }}" />
@stop
@section('seoPageTitle')
    <title>{{ $pageTitle }}</title>
@stop
@section('styles')
    @parent
    {!! RecaptchaV3::initJs() !!}
@stop
@section('content')
    <div class="az-signin-wrapper"
        @if (!empty($websiteSettings) && $websiteSettings->getMeta('theme_color')) style="background-color: {{ $websiteSettings->getMeta('theme_color') }}" @endif>
        <div class="az-card-signin">
            <div class="az-signin-header">
                <h1 class="az-logo"><img class="logo-img"
                        src="{{ $websiteSettings ? PP($websiteSettings->getMeta('logo_main')) : '' }}" alt="">
                </h1>
                @if (!empty($userMessage))
                    {!! $userMessage !!}
                @endif
                @if (session()->has('login_tries') && session('login_tries') >= 1)
                    <div class="alert alert-warning" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Warning</strong> {{ 3 - session('login_tries') }} {{ lang('login_attempt_left') }}
                    </div>
                @endif
            </div><!-- az-signin-header -->
            {!! Form::open(['autocomplete' => 'new', 'id' => 'login-form']) !!}
            <div class="form-group">
                <input type="text" name="email_" class="form-control form-control-lg"
                    value="{{ request()->input('user_email') }}" placeholder="{{ lang('email') }}" autocomplete="none">
            </div>
            <div class="form-group">
                <input type="password" name="password_" id="password" class="form-control"
                    placeholder="{{ lang('password') }}" autocomplete="none">
            </div>

            {!! RecaptchaV3::field('login') !!}
            <button type="submit" class="btn btn-default btn-lg btn-block"
                style="background:#373737 ;color:#fff;">{{ lang('sign_in') }}</button>
            <input type="hidden" name="user_email" value="" />
            <input type="hidden" name="password" value="" />
            {!! Form::close() !!}



            {{-- <div class="az-signin-footer mt-3">
      <p><a href="{{ apa('forgot_password') }}">{{ lang('forgot_password') }}</a></p>
    </div> --}}
            <!-- az-signin-footer -->
        </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->
@stop

@section('scripts')
    @parent

    <script>
        function submitForm() {
            $('#login-form').submit();
        }

        $('#login-form').validate({
            rules: {

                'g-recaptcha-response': {
                    required: true,
                },
                'email_': {
                    required: true,

                },
                'password_': {
                    required: true,

                },

                messages: {
                    'g-recaptcha-response': {
                        'required': "{{ lang('field_required') }}"
                    },
                    'email_': {
                        'required': "{{ lang('field_required') }}"
                    },
                    'password_': {
                        'required': "{{ lang('field_required') }}"
                    },

                }
            }

        });
        $(document).ready(function() {
            $('[name=g-recaptcha-response]').addClass('login');
        });
        $(function() {

            $('#login-form').on('submit', function() {

                if (grecaptcha.getResponse) {
                    $('[name="user_email"]').val($('[name="email_"]').val());
                    $('[name="email_"]').val('');
                    $('[name="password"]').val($('[name="password_"]').val());
                    $('[name="password_"]').val('');
                    return true;
                } else {

                }
                grecaptchaExecute('login');

                return false;
            });

        });
    </script>
@stop
