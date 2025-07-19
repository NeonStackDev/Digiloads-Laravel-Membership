@php
    $about = getContent('about.content', true);
    $counterElements = getContent('counter.element', false);
@endphp
<section class="about-section  section-bg py-80">
    <div class="container">
        <div class="row why-choose_item">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                <div class="about-content">
                    <h3>{{ __(@$about->data_values->heading) }}</h3>
                    <p>{{ __(@$about->data_values->sub_heading) }}</p>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 justify-content-center d-flex">
                <div class="about-sec_thumb top_image_bounce">
                    <img src="{{ getImage(getFilePath('about') . '/' . @$about->data_values->about_image) }}"
                        alt="@lang('image')">
                </div>
            </div>
        </div>
    </div>
    <!-- ====counter section Start Here ======= -->
    <div class="counter-section pt-80 reveal">
        <div class="container">
            <div class="row items gy-4 text-center">
                @foreach ($counterElements as $item)
                    <div class="col-xl-4 col-lg-4 col-sm-6 ">
                        <div class="counter-box">
                            <img class="category-bg" data-value="-2"
                                src="{{ asset($activeTemplateTrue . 'images/category-bg.png') }}"
                                alt="@lang('banner image1')">
                            <span class="counter-icon">
                                @php
                                    echo @$item->data_values->counter_icon;
                                @endphp
                            </span>
                            <div class="counter-content">
                                <h2 class="odometer" data-count="{{ __($item->data_values->counter_digit) }}"></h2>
                                <p>{{ __(@$item->data_values->title) }}</p>
                            </div>
                            <span class="circle"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- ========= counter section End Here ======== -->
</section>
