@extends($activeTemplate . 'layouts.frontend')
@section('content')
@php
    $banner = getContent('banner.content', true);
    $categories = App\Models\Category::where('status', 1)->latest()->limit(6)->get();
@endphp

<section class="hero hero-bg">
    <span class="circle1"></span>
    <span class="circle2"></span>
    <div class="circle3"></div>
    <img class="hero-shape-bg" data-value="-10" src="{{ asset($activeTemplateTrue . 'images/hero-shape.png') }}" alt="@lang('banner image3')">

    <div class="container">
        <div class="animationBox_container">
            <span class="box1 top_image_bounce">
                <span class="box-img">
                    <img class="animation-img" data-value="-2" src="{{ asset($activeTemplateTrue . 'images/gift.png') }}" alt="@lang('banner image1')">
                </span>
            </span>

            <span class="box3 top_image_bounce">
                <span class="box-img">
                    <img class="animation-img" data-value="-10" src="{{ asset($activeTemplateTrue . 'images/happy.png') }}" alt="@lang('banner image2')">
                </span>
            </span>

            <span class="box6 left_image_bounce">
                <span class="box-img">
                    <img class="animation-img" data-value="-2" src="{{ asset($activeTemplateTrue . 'images/employee.png') }}" alt="@lang('banner image5')">
                </span>
            </span>

            <span class="box7 left_image_bounce">
                <span class="box-img">
                    <img class="animation-img" data-value="10" src="{{ asset($activeTemplateTrue . 'images/human-resources.png') }}" alt="banner image6">
                </span>
            </span>
        </div>
        <div class="row justify-content-center position-relative">
            <div class="col-xl-7 col-lg-8 col-md-8 text-center">
                <div class="heror-content">
                    <p class="sub-heading">{{ __($banner->data_values->heading) }}</p>
                    <h1 class="heading">{{ __($banner->data_values->sub_heading) }}</h1>
                    <div class="search-bar">
                        <input class="search-form--control searchProduct" id="search" autocomplete="off"
                            name="search" type="text" placeholder="@lang('Search')...">
                        <button class="search-btn" type="submit"> <i class="las la-search icon"></i></button>
                    </div>
                </div>
            </div>
            {{-- search result --}}
            <div class="search-result-wrap d-none">
                <ul>
                    <li class="search-results searchResults"></li>
                </ul>
            </div>
        </div>
        <div class="row gy-4 category-wraper justify-content-center pt-1">
            @foreach ($categories as $category)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 ">
                    <div class="category-card_body">
                        <img class="category-bg" data-value="-2"
                            src="{{ asset($activeTemplateTrue . 'images/category-bg.png') }}" alt="banner image1">

                        <div class="category-img">
                            <a href="{{ route('filter.category.products', $category->id) }}">@php echo $category->icon;@endphp</a>
                        </div>
                        <div class="category-content">
                            <a href="{{ route('filter.category.products', $category->id) }}">
                                <h6>{{ __($category->name) }}</h6>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if ($sections->secs != null)
    @foreach (json_decode($sections->secs) as $sec)
        @include($activeTemplate . 'sections.' . $sec)
    @endforeach
@endif
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            "use strict";

            $('.searchProduct').on('keyup', function() {
                var baseUrl = '{{ url('/') }}';
                var searchValue = $(this).val().trim();
                var searchResults = $(this).closest('.position-relative').find('.search-results');

                if (searchValue.length >= 3) {
                    $.ajax({
                        url: '{{ route('product.search') }}',
                        type: 'get',
                        data: {
                            search: searchValue
                        },
                        dataType: 'json',
                        success: function(response) {
                            searchResults.empty();

                            $('.search-result-wrap').removeClass('d-none')

                            if (response.length > 0) {
                                $.each(response, function(index, product) {
                                    var productName = product.name;
                                    var productSlug = slugify(productName);
                                    var productId = product.id;

                                    var productLink = baseUrl + '/product/' +
                                        productSlug + '/' + productId;

                                    var resultItem = $('<a>' + productName + '</a>');
                                    resultItem.attr('href', productLink);
                                    searchResults.append(resultItem);
                                    resultItem.animate({
                                        opacity: 1,
                                        marginLeft: '10px'
                                    }, 500);
                                });
                                searchResults.show();
                            } else {
                                searchResults.html('<p>No results found.</p>');

                            }
                        }.bind(this)
                    });
                } else {
                    searchResults.empty();
                    $('.search-result-wrap').addClass('d-none');
                }
            });

            $('.close-hide-show').on('click', function() {
                var searchResults = $(this).closest('.position-relative').find('.search-results');
                searchInput.val('');
                searchResults.empty();
            });

            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }
        });
    </script>
@endpush
