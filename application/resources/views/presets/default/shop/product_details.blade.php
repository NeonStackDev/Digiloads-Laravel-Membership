@extends($activeTemplate . 'layouts.frontend')
@section('content')

<!-- ==================== Product Details Here ==================== -->
<section class="product-details-area py-80">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="product-details-left">
                    <div class="product-details-left__content">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="product-details-left__thumb"
                                    style="background-image: url({{ getImage(getFilePath('productThumbnail') . '/' . @$product->thumbnail) }});">
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <a href="{{ $product->demo_link }}" target="_blank">
                                <i class="fab fa-hive live-watch"></i>
                                <p class="mt-3">@lang('Live Preview') <i class="far fa-eye"></i></p>
                            </a>

                            <div class="tab-content mt-3" id="myTabContent">
                                @if (!empty($productImages) && is_array($productImages))
                                    @foreach ($productImages as $index => $productImage)
                                        <div class="tab-pane fade{{ $index === 0 ? ' show active' : '' }}"
                                            id="image-tab-{{ $index }}" role="tabpanel"
                                            aria-labelledby="image-tab-{{ $index }}" tabindex="0">
                                            <div class="product-details-left__thumb">
                                                <a class="image-popup"
                                                    href="{{ getImage(getFilePath('productImage') . '/' . @$productImage) }}">
                                                    <span>@lang('Screenshots')<i class="fas fa-expand"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div class="row py-4">
                        <div class="product-info">
                            <div class="product-title">
                                <h3>{{ __($product->name) }}</h3>
                                <ul class="social-list">
                                    <li class="social-list__item"><a
                                            href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ $product->name }}"
                                            class="social-list__link" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a> </li>
                                    <li class="social-list__item"><a
                                            href="https://twitter.com/intent/tweet?status={{ $product->name }}+{{ Request::url() }}"
                                            class="social-list__link" target="_blank"> <i
                                                class="fab fa-twitter"></i></a></li>
                                    <li class="social-list__item"><a
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ $product->name }}&source=digiloads"
                                            class="social-list__link" target="_blank"> <i
                                                class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                            <div class="tag-rating-sales-wrap">
                                <p class="cate-title">{{ __(@$product->category->name) }}</p>
                                <div class="ratings-box me-3">
                                    <div class="review-wrapper">
                                        @php
                                            $averageRatingHtml = calculateAverageRating($product->average_rating);
                                            if (!empty($averageRatingHtml['ratingHtml'])) {
                                                echo $averageRatingHtml['ratingHtml'];
                                            }
                                        @endphp
                                        <p class="review-count">
                                            @if (empty($product->review_count && $product->average_rating))
                                            @else
                                                ({{ __($product->review_count) }})
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="price">
                                    <h5 class="product-price"> <i class="fas fa-shopping-cart"></i>
                                        {{$product->sale }} @lang('sales')</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs coustome-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="false"
                                    tabindex="-1">
                                    @lang('Description')
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link " id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                    type="button" role="tab" aria-controls="contact" aria-selected="false"
                                    tabindex="-1">
                                    @lang('Reviews')
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="about-right-content">
                                            <div class="section-heading mb-0 wyg">
                                                <p class="section-heading__desc mb-4 wyg">
                                                    @php echo $product->description; @endphp
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tab-review-wrap">
                                            <ul class="comment-list">
                                                @forelse($reviews as $item)
                                                    <li class="comment-list__item d-flex flex-wrap">
                                                        <div class="comment-list__thumb">
                                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$item->user->image) }}"
                                                                alt="image">
                                                        </div>
                                                        <div class="comment-list__content">
                                                            <h4 class="comment-list__name">{{ @$item->user->username }}
                                                            </h4>
                                                            <div
                                                                class="time-rating-warper d-flex justify-content-between">
                                                                <span class="comment-list__time"> <span
                                                                        class="comment-list__time-icon"><i
                                                                            class="far fa-clock"></i></span>
                                                                    {{ diffForHumans($item->created_at) }} </span>
                                                                <ul class="rating-list mb-2">
                                                                    @php
                                                                        $averageRatingHtml = calculateAverageRating($product->average_rating,);
                                                                        if ( !empty($averageRatingHtml['ratingHtml'])) {
                                                                            echo $averageRatingHtml['ratingHtml'];
                                                                        }
                                                                    @endphp
                                                                </ul>
                                                            </div>
                                                            <p class="comment-list__desc">{{__($item->message) }}</p>
                                                            <div class="comment-list__reply">
                                                                <a class="comment-list__reply-text"
                                                                    href="javascript:void(0)"><span
                                                                        class="comment-list__reply-icon"></span></a>
                                                                <span>{{ showDateTime($item->created_at) }}</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <p>@lang('No Reviews')</p>
                                                @endforelse
                                            </ul>
                                        </div>
                                        @if ($reviews->hasPages())
                                            <div class="py-4">
                                                {{ paginateLinks($reviews) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row pt-3">
                                        <div class="contactus-form">
                                            <div class="account-form__content mb-4">
                                                <h3 class="account-form__title mb-2"> @lang('Review this product') </h3>
                                                <p class="account-form__desc mb-2">@lang('Your review goes here')</p>
                                            </div>

                                            <form action="{{ route('user.reviews.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="row gy-3">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form--label"> @lang('Rating') <i
                                                                    class="fas fa-star"></i></label>
                                                            <div class="rating-stars">
                                                                <input type="hidden" name="rating" id="rating"
                                                                    value="0">
                                                                <i class="far fa-star" data-rating="1"></i>
                                                                <i class="far fa-star" data-rating="2"></i>
                                                                <i class="far fa-star" data-rating="3"></i>
                                                                <i class="far fa-star" data-rating="4"></i>
                                                                <i class="far fa-star" data-rating="5"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="message" class="form--label">
                                                                @lang('Message')</label>
                                                            <textarea class="form--control" name="message" placeholder="@lang('Message')" id="message"></textarea>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-sm-12 text-end">
                                                        <button type="submit" class="btn btn--base">
                                                            @lang('Submit') <i class="fas fa-arrow-right"></i>
                                                            <span style="top: 40.6094px; left: 80px;"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ps-md-4">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="product-info-right">
                            <div class="box_content">
                                @if ($product->is_free == 1)
                                    <h5 class="text-center">{{ $general->cur_sym }} 00.00</h5>
                                    <a class="btn btn--base" href="{{ route('user.product.payment', $product->id) }}">
                                        <i class="fas fa-cart-plus"></i> @lang('Free')
                                    </a>
                                @else
                                    <div class="price-wrapper d-flex justify-content-center">
                                        @if (isset($product->discount))
                                            <h5 class="me-2">
                                                {{ $general->cur_sym }}
                                                {{ showAmount($product->price - ($product->price * $product->discount / 100)) }}
                                            </h5>
                                            <h5 class="discount-price">
                                                {{ $general->cur_sym }}
                                                {{ showAmount($product->price) }}
                                            </h5>
                                        @else
                                            <h5 class="me-2">
                                                {{ $general->cur_sym }}
                                                {{ showAmount($product->price) }}
                                            </h5>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <a class="btn btn--base" href="{{ route('user.product.payment', $product->id) }}">
                                            <i class="fas fa-cart-plus"></i> @lang('Buy Now')
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="box_content">
                                <div class="txt">
                                    <h6>@lang('Updated')</h6>
                                    <p>{{ showDateTime($product->updated_at) }}</p>
                                </div>
                                <div class="txt">
                                    <h6>@lang('Published')</h6>
                                    <p>{{ showDateTime($product->created_at) }}</p>
                                </div>
                            </div>
                            <div class="box_content">
                                <div class="txt">
                                    <h6>@lang('Category')</h6>
                                    <p>{{ __(@$product->category->name) }}</p>
                                </div>
                            </div>

                            @if($product->user)
                            <div class="box_content">
                                <div class="vendor-profile-card">
                                    <div class="vendor-profile-content">
                                        <div class="vendor-profile-txt">
                                            <img src="{{ getImage(getFilePath('userProfile').'/'.@$product->user->image,getFileSize('userProfile')) }}" alt="@lang('agent')" class="vendor-profile-img">
                                            <a href="{{ route('vendor.page', ['slug' => slug($product->user->username), 'id' => $product->user->id])}}" class="vendor-profile-name mt-3">@lang('Name'): {{@$product->user->fullname}}</a>
                                            <p class="vendor-profile-email">@lang('Email'): {{ @$product->user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Product Details End ==================== -->

<!-- ==================== Our Products Start Here ==================== -->
<section class="echommerce-products section-bg py-80">
    <span class="circle1"></span>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-heading  text-left">
                    <h2 class="section-heading__title pb-4">@lang('Related Products')</h2>
                    <div class="border-bottom pb-3"></div>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center latest-products card_wraper" id="card_wraper">
            @forelse($relatedProducts as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card_body">
                        <div class="card-img">
                            <a
                                href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}">
                                <img src="{{ getImage(getFilePath('productThumbnail') . '/' . @$product->thumbnail) }}"
                                    alt="product image">
                            </a>
                            @if (isset($product->discount))
                                <div class="product-badge bg--info">
                                    @if ($product->is_free == 1)
                                        <p>@lang('Free')</p>
                                    @else
                                        <p>{{ $product->discount }}%</p>
                                    @endif
                                </div>
                            @else
                                <div class="product-badge bg--base">
                                    <p>@lang('New')</p>
                                </div>
                            @endif
                        </div>
                        <div class="content">
                            <div class="content-text">
                                <p><a href="{{ route('filter.category.products', $product->category->id) }}">
                                        {{ __($product->category->name) }} </a></p>
                                <h5><a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}"
                                        target="_blank">
                                        @if (strlen(__($product->name)) > 30)
                                            {{ substr(__($product->name), 0, 30) . '...' }}
                                        @else
                                            {{ __($product->name) }}
                                        @endif
                                    </a></h5>
                            </div>
                            <div class="card-meta">
                                <div class="sale">
                                    <p class="amount"><i class="fas fa-bolt"></i> {{ __($product->sale) }}
                                        @lang('sales')</p>
                                    <div class="review-wrapper">
                                        @php
                                            $averageRatingHtml = calculateAverageRating($product->average_rating);
                                            if (!empty($averageRatingHtml['ratingHtml'])) {
                                                echo $averageRatingHtml['ratingHtml'];
                                            }
                                        @endphp
                                        <p class="review-count">
                                            @if (empty($product->review_count && $product->average_rating))
                                            @else
                                                ({{ __($product->review_count) }})
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="btm">
                                    <div class="price">
                                        @if ($product->is_free == 1)
                                            <h5 class="product-price">{{ $general->cur_sym }} 00.00</h5>
                                        @else
                                            <h5 class="product-price">{{ $general->cur_sym }}
                                                {{ showAmount($product->price) }}</h5>
                                        @endif
                                    </div>
                                    <div class="cart">
                                        @if ($product->is_free == 1)
                                            <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}"
                                                class="btn btn--base btn--sm"><i class="fas fa-cart-plus"></i>
                                                @lang('Free')</a>
                                        @else
                                            <a href="{{ route('user.product.payment', $product->id) }}"
                                                class="btn btn--base btn--sm"><i class="fas fa-cart-plus"></i>
                                                @lang('Purchase')</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __($emptyMessage) }}</p>
            @endforelse

        </div>
    </div>
    <span class="circle2"></span>
</section>
<!-- ==================== / Our Products  ==================== -->
@endsection


@push('style')
    <style>
        .wyg h1,
        .wyg h2,
        .wyg h3,
        .wyg h4 {
            color: hsl(var(--black));
        }

        .wyg p {
            color: hsl(var(--black));
        }

        .wyg ul {
            margin: 35px;
        }

        .wyg ul li {
            list-style-type: disc;
            color: hsl(var(--black));
            font-family: var(--body-font);
        }

        /*========= dark css =======*/
        .dark .wyg h1,
        .dark .wyg h2,
        .dark .wyg h3,
        .dark .wyg h4 {
            color: hsl(var(--white)/.6);
        }

        .dark .wyg p {
            color: hsl(var(--white)/.6);
        }

        .dark .wyg ul {
            margin: 35px;
        }

        .dark .wyg ul li {
            list-style-type: disc;
            color: hsl(var(--white));
        }
    </style>
@endpush

@push('script')
    <script>
        // rating set
        $(document).ready(function() {
            "use strict"

            $('.rating-stars i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });

            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });

            function updateStars(rating) {
                var stars = $('.rating-stars i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }

            var initialRating = parseInt($('#rating').val());
            if (initialRating > 0) {
                updateStars(initialRating);
            }

        });
        // end rating set
    </script>
@endpush
