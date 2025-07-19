@extends($activeTemplate.'layouts.frontend')

@section('content')
<!-- ==================== SignUp Section ==================== -->
<section class="signup-section sect py-80">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 d-flex flex-column justify-content-center">

                <div class="signup-thumb">
                    <img src="{{asset($activeTemplateTrue.'images/login.png')}}">
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                <div class="sign-up_box">
                    <h3>@lang('Sign In Your Account')</h3>
                    <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                        @csrf
                        <div class="sign-form">
                            <div class="row gy-3">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="username" class="form--label"> @lang('Username or Email')</label>
                                            <input type="text" class="form--control" id="username" name="username" value="{{ old('username') }}" placeholder="@lang('User Name  Or Email')" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="your-password" class="form--label">@lang('Password')</label>
                                        <div class="input-group">
                                            <input id="your-password" type="password" class="form-control form--control" name="password" placeholder="@lang('Password')"
                                            required>
                                            <div class="password-show-hide fas fa-lock" id="#your-password"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <x-captcha></x-captcha>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex flex-wrap justify-content-between">
                                            <div class="form--check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">@lang('Remember me')</label>
                                            </div>
                                            <a href="{{ route('user.password.request') }}" class="forgot-password text--base">@lang('Forgot Your Password?')</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn--base" id="recaptcha">
                                            @lang('Sign In') <i class="fas fa-arrow-right"></i>
                                            <span style="top: 40.6094px; left: 80px;"></span>
                                        </button>
                                    </div>
                                </div>
                                <p class="pt-3">@lang('Don\'t have any account?') <a href="{{ route('user.register') }}" class="text--base">@lang('Create Account')</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== / SignUp Section ==================== -->
@endsection
