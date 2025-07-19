
    <div class="row gy-4 justify-content-center">
        @forelse($products as $product)
        <div class="col-xl-4 col-lg-6 col-md-6" >
            <div class="card_body">
                <div class="card-img">
                    <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                        <img src="{{ getImage(getFilePath('productThumbnail').'/'.@$product->thumbnail)}}" alt="product image">
                    </a>
                    @if(isset($product->discount))
                    <div class="product-badge bg--info">
                        @if($product->is_free ==1)
                        <p>@lang('Free')</p>
                        @else
                        <p>{{$product->discount}}%</p>
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
                        <p><a href="{{route('filter.category.products',$product->category->id)}}"> {{__($product->category->name)}} </a></p>
                        <h5><a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" target="_blank">
                            @if(strlen(__($product->name)) >30)
                            {{substr( __($product->name), 0,30).'...' }}
                            @else
                            {{__($product->name)}}
                            @endif
                        </a></h5>
                    </div>
                    <div class="card-meta">
                        <div class="sale">
                            <p class="amount"><i class="fas fa-bolt"></i> {{$product->sale}} @lang('sales')</p>
                            <div class="review-wrapper">
                                @php
                                $averageRatingHtml = calculateAverageRating($product->average_rating);
                                if (!empty($averageRatingHtml['ratingHtml'])) {
                                    echo $averageRatingHtml['ratingHtml'];
                                }
                            @endphp
                            <p class="review-count">
                                @if(empty($product->review_count && $product->average_rating ))
                                 @else
                                   ({{__( $product->review_count)}})
                                 @endif
                            </p>
                            </div>
                        </div>
                        <div class="btm">
                            <div class="price">
                                @if($product->is_free == 1)
                                <h5 class="product-price">{{$general->cur_sym}} 00.00</h5>
                                @else
                                <h5 class="product-price">{{$general->cur_sym}} {{showAmount($product->price)}}</h5>
                                @endif
                            </div>
                            <div class="cart">
                                @if($product->is_free == 1)
                                <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" class="btn btn--base btn--sm outline"><i class="fas fa-cart-plus"></i> @lang('Free')</a>
                                @else
                                <a href="{{route('user.product.payment',$product->id)}}" class="btn btn--base btn--sm"><i class="fas fa-cart-plus"></i> @lang('Purchase')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">{{__($emptyMessage)}}</p>
        @endforelse
    </div>
