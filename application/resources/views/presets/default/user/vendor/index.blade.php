@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ========  Feature section ===== -->
    <section class="shop-section  py-120 section-bg">
        <div class="container">
            <div class="row justify-content-center pt-1 gy-4 card_wraper" id="card_wraper">
                <div class="col-lg-12">
                    <form action="{{route('vendor.product.search',$user->id)}}" method="get">
                        <div class="d-flex flex-wrap justify-content-end mb-3">
                            <div class="d-inline">
                                <div class="input-group justify-content-end">
                                    <input type="text" name="search" class="form-control form--control"
                                        placeholder="Search by title" id="search">
                                    <button class="btn btn--base input-group-text" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- card  -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 main-content">
                    @include($activeTemplate . 'components.shop')
                </div>
            </div>
            <div class="row mt-4">
                @if ($products->hasPages())
                    <div class="col-md-12 d-flex justify-content-center">
                        {{ paginateLinks($products) }}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ======== / Feature section ===== -->
@endsection
