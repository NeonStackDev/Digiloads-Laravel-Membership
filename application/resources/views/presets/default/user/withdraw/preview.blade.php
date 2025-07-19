@extends($activeTemplate.'layouts.master')
@section('content')
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body account-form">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4 justify-content-center">
                <h5 class="card-title">@lang('Withdraw Via') {{ $withdraw->method->name }}</h5>

                    <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            @php
                            echo $withdraw->method->description;
                            @endphp
                        </div>
                        <x-custom-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}"></x-custom-form>
                        @if(auth()->user()->ts)
                        <div class="form-group mb-2">
                            <label>@lang('Google Authenticator Code')</label>
                            <input type="text" name="authenticator_code" class="form-control form--control" required>
                        </div>
                        @endif
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn--base w-50">@lang('Submit')</button>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection
