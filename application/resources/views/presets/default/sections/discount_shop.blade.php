@php
    $discountShop = getContent('discount_shop.content', true);
    $discountProducts = App\Models\Product::where('status', 1)
        ->with(['productImages', 'category'])
        ->where('discount', '>', 0)
        ->latest()
        ->limit(8)
        ->get();
@endphp
<!-- ========  new item section ===== -->
<section class="new-section pt-120" id="discount">
    <div class="container">
        <div class="row justify-content-left text-left">
            <div class="col-xl-7 col-lg-8 hero-content">
                <h2>{{__(@$discountShop->data_values->heading) }}</h2>
            </div>
        </div>
        <div class="row justify-content-center pt-5 gy-4 new-product-card_wraper">
            <!-- card  -->
            @foreach($discountProducts as $product)
                <div class="col-md-4 col-sm-6">
                    <div class="product-container align-items-center">
                        <p class="product-discount-badge">
                            {{ $product->discount }}%
                        </p>
                        <div class="thumb">
                            <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}">
                                <img src="{{ getImage(getFilePath('productThumbnail') . '/' . @$product->thumbnail) }}"
                                    alt="@lang('product Image')">
                            </a>
                        </div>
                        <div class="product-card-body">
                            <div class="card-text_content">
                                <h6 class="product-title"><a
                                        href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}"
                                        title="{{ $product->name }}">
                                        @if (strlen(__($product->name)) > 10)
                                            {{ substr(__($product->name), 0, 28) . '...' }}
                                        @else
                                            {{ __($product->name) }}
                                        @endif
                                    </a>
                                </h6>
                                @php
                                    $averageRatingHtml = calculateAverageRating($product->average_rating);
                                    if (!empty($averageRatingHtml['ratingHtml'])) {
                                        echo $averageRatingHtml['ratingHtml'];
                                    }
                                @endphp
                            </div>
                            <div class="product-meta">
                                @if ($product->is_free == 1)
                                    <p>{{ $general->cur_sym }} 00.00</p>
                                @else
                                    <p>{{ $general->cur_sym }}<span
                                            class="text-decoration-line-through">{{ showAmount($product->price) }}</span>
                                        {{ $general->cur_sym }}{{ (showAmount($product->price) * (100 - $product->discount)) / 100 }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- / product card  -->
            <div class="pt-4 text-center">
                <a href="{{ route('browse') }}" class="btn btn--base ">@lang('View More')</a>
            </div>
        </div>
    </div>
</section>
<!-- ======== / new item section ===== -->
