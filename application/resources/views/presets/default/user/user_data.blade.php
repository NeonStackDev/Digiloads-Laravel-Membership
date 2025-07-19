@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="signup-section  py-80">
    <div class="container">
        <div class="row gy-4 justify-content-center">
        <div class="col-md-12 sign-up_box">
                <h3>{{ __($pageTitle) }}</h3>
                <form method="POST" action="{{ route('user.data.submit') }}">
                    @csrf
                    <div class="sign-form">
                    <div class="row gy-3">
                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="firstname" class="form--label"> @lang('First Name')</label>
                                <input type="text" class="form--control" id="firstname" name="firstname"
                                value="{{ old('firstname') }}" required>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="lastname" class="form--label"> @lang('Last Name')</label>
                                <input type="text" class="form--control" id="lastname" name="lastname"
                                value="{{ old('lastname') }}" required>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="address" class="form--label"> @lang('Address')</label>
                                <input type="text" class="form--control" id="address" name="address"
                                value="{{ old('address') }}" required>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="state" class="form--label"> @lang('State')</label>
                                <input type="text" class="form--control" id="state" name="state"
                                value="{{ old('state') }}" required>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="zip" class="form--label"> @lang('Zip')</label>
                                <input type="text" class="form--control" id="zip" name="zip"
                                value="{{ old('zip') }}" required>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="city" class="form--label"> @lang('City')</label>
                                <input type="text" class="form--control" id="city" name="city"
                                value="{{ old('city') }}" required>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-lg-6 col-md-6">
                            <button type="submit" class="btn btn--base">
                                @lang('Submit') <i class="fa-sharp fas fa-arrow-right"></i>
                                <span style="top: 40.6094px; left: 80px;"></span>
                            </button>
                        </div>
                    </div>
                    </div>
               </form>
        </div>
    </div>
</div>
</section>
@endsection
