@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $contact = getContent('contact_us.content', true);
    @endphp

    <section class="contact-section pt-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 text-center hero-content">
                    <h2 class="pb-40">{{ __(@$contact->data_values->heading) }} </h2>
                    <p class="pb-40">{{ __(@$contact->data_values->sub_heading) }}</p>
                </div>
            </div>
            <div class="row gy-4 mb-3">
                <div class="col-xl-6 col-lg-6">
                    <div class="row justify-content-center ">
                        <div class="col-xl-12 col-lg-12">
                            <div class="contactus-form">
                                <form method="post" action="" class="verify-gcaptcha">
                                    @csrf
                                    <div class="row gy-md-4 gy-3">
                                        <div class="col-sm-6">
                                            <input name="name" type="text" class="form--control"
                                                value="@if (auth()->user()) {{ auth()->user()->fullname }} @else{{ old('name') }} @endif"
                                                @if (auth()->user()) readonly @endif required
                                                placeholder="@lang('Name')">
                                        </div>
                                        <div class="col-sm-6">
                                            <input name="email" type="email" class="form--control"
                                                value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                                @if (auth()->user()) readonly @endif required
                                                placeholder="@lang('Email')">
                                        </div>
                                        <div class="col-sm-12">
                                            <input name="subject" type="text" class="form--control"
                                                value="{{ old('subject') }}" required placeholder="@lang('Subject')">
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form--control" name="message" placeholder="@lang('Write your note')"></textarea>
                                        </div>
                                        <x-captcha></x-captcha>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn--base">
                                                @lang('Send Your Message') <i class="fas fa-paper-plane"></i>
                                                <span style="top: 249px; left: 75.9844px;"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="row g-4 contact-infowraper">
                        <div class="col-lg-6 col-md-6">
                            <div class="info-box ">
                                <span class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <div class="info-content">
                                    <h4>@lang('Call Us')</h4>
                                    <P><a
                                            href="tel:{{ @$contact->data_values->contact_number }}">{{ @$contact->data_values->contact_number }}</a>
                                    </P>
                                </div>
                                <span class="circle"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="info-box">
                                <span class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <div class="info-content">
                                    <h4>@lang('Email')</h4>
                                    <P><a
                                            href="mailto:{{ @$contact->data_values->email_address }}">{{ @$contact->data_values->email_address }}</a>
                                    </P>
                                </div>
                                <span class="circle"></span>
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="info-box">
                                <span class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <div class="info-content">
                                    <h4>@lang('Address')</h4>
                                    <P>{{ __(@$contact->data_values->contact_details) }}</P>
                                </div>
                                <span class="circle"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="circle1"></span>
    </section>

    <section class="map-section pt-80 container">
        <div class="row">
            <div class="col-12 map-box">
                <iframe
                    src="https://maps.google.com/maps?q={{ $contact->data_values->latitude }},{{ $contact->data_values->longitude }}&hl=es;z=14&amp;output=embed"
                    width="100%" height="450" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
@endsection
