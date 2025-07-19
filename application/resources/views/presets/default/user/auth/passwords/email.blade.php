@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="signup-section  py-80">
    <div class="container">
        <div class="row gy-4 justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">
            <h5>{{ __($pageTitle) }}</h5>
            <div class="mb-4">
                <p>@lang('To recover your account please provide your email or username to find your account.')
                </p>
            </div>
            <form method="POST" action="{{ route('user.password.email') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Email or Username')</label>
                    <input type="text" class="form-control form--control" name="value"
                        value="{{ old('value') }}" required autofocus="off">
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn--base w-50">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
