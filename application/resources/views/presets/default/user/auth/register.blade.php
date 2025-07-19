@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
    @endphp
    <!-- ==================== SignUp Section ==================== -->
    <section class="signup-section section-bg py-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 d-flex flex-column justify-content-center">

                    <div class="signup-thumb">
                        <img src="{{ asset($activeTemplateTrue . 'images/signup.png') }}">
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12">
                    <div class="sign-up_box">
                        <h3>@lang('Sign Up Your Account')</h3>
                        <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                            @csrf
                            <div class="sign-form">
                                <div class="row gy-3">
                                    @if (session()->get('reference') != null)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="referenceBy" class="form--label">@lang('Reference by')</label>
                                                <input type="text" class="form--control" name="referBy" id="referenceBy"
                                                    value="{{ session()->get('reference') }}" readonly>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="form--label"> @lang('Username')</label>
                                            <input type="text" class="form--control" id="username" name="username"
                                                value="{{ old('username') }}" placeholder="@lang('Username')" required>
                                            <small class="text-danger usernameExist"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email" class="form--label">@lang('E-Mail Address')</label>
                                            <input type="email" class="form--control" id="email" name="email"
                                                value="{{ old('email') }}" placeholder="@lang('Email')" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form--label">@lang('Country')</label>
                                            <div class="col-sm-12">
                                                <select class="form--control" name="country">
                                                    @foreach ($countries as $key => $country)
                                                        <option data-mobile_code="{{ $country->dial_code }}"
                                                            value="{{ $country->country }}" data-code="{{ $key }}">
                                                            {{ __($country->country) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form--label">@lang('Mobile')</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group country-code">
                                                <span class="input-group-text mobile-code">
                                                </span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" class="form-control form--control checkUser"
                                                    name="mobile" value="{{ old('mobile') }}"
                                                    placeholder="@lang('Mobile')" required>
                                            </div>
                                            <small class="text-danger mobileExist"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="your-password" class="form--label">@lang('Password')</label>
                                        <div class="input-group">
                                            <input id="your-password" type="password" class="form-control form--control"
                                                name="password" placeholder="@lang('Password')" required>
                                            <div class="password-show-hide fas fa-lock" id="#your-password"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="confirm-password" class="form--label">@lang('Confirm Password')</label>
                                        <div class="input-group">
                                            <input id="confirm-password" type="password" class="form-control form--control"
                                                name="password_confirmation" placeholder="@lang('Confirm Password')" required>
                                            <div class="password-show-hide fas fa-lock" id="#confirm-password"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <x-captcha></x-captcha>
                                    </div>

                                    @if ($general->agree)
                                        <div class="col-sm-12">
                                            <div class="form--check">
                                                <input class="form-check-input" type="checkbox" id="agree"
                                                    @checked(old('agree')) name="agree" required>
                                                <div class="form-check-label">
                                                    <label class="" for="remember"> @lang('I agree with') @foreach ($policyPages as $policy)
                                                    </label>
                                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                                        class="text--base">{{ __($policy->data_values->title) }}</a>
                                                    <label class="" for="remember">
                                                        @if (!$loop->last)
                                                        @endif
                                    @endforeach </label>
                                </div>
                            </div>
                    </div>
                    @endif
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn--base" id="recaptcha">
                            @lang('Sign Up') <i class="fa-sharp fas fa-arrow-right"></i>
                            <span style="top: -1px; left: 369px;"></span>
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <p class="pt-3"> @lang('Already Have An Account')? <a href="{{ route('user.login') }}"
                                class="text--base">@lang('Login Now')</a></p>
                    </div>
                </div>
            </div>
            </form>
        </div>
        </div>
        </div>
        </div>
    </section>
    <!-- ==================== / SignUp Section ==================== -->



    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
    <style>
        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
           

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
