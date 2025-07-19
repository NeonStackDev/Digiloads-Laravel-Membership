@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
$min = 5;
$max = 10000;
@endphp
<!-- ========  Feature section ===== -->
<section class="shop-section  py-120 section-bg">
    <div class="container" >
        <div class="row justify-content-center pt-1 gy-4 card_wraper" id="card_wraper">
            <aside class="col-xl-3 col-lg-3 col-md-12">
                <div class="filter-form">
                    <div class="sidebar_body">
                        <div class="sidebar-wraper mb-4">
                            <div class="sidebar-header">
                                <div class="aside-search-box">
                                    <input class="form--input__field form--control mb-0" id="searchValue" name="search" type="text" placeholder="@lang('Search')">
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-wraper mb-4">
                            <div class="sidebar-categories">
                                <div class="script-item">
                                    <p class="mb-1">@lang('Categories')</p>
                                    @foreach($categories as $category)
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input filter-by-category" name="categories" type="checkbox" value="{{$category->id}}" id="chekbox-{{$loop->index}}">
                                            <label class="form-check-label" for="chekbox-{{$loop->index}}">
                                                {{__($category->name)}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-wraper mb-4">
                            <div class="range-slider-box">
                                <p class="pb-2 pt-1">@lang('Price Range')-({{$general->cur_sym}}<span
                                    id="minTxt">@lang('5')</span>-{{$general->cur_sym}}<span
                                    id="maxTxt">@lang('10000')</span>)
                                </p>

                                <div class="slider-box pb-2">
                                    <div class="range-slider">
                                        <div id="p_range"></div>
                                        <input type="hidden" name="min" id="min">
                                        <input type="hidden" name="max" id="max">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
              <!-- card  -->
              <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 main-content">
              @include($activeTemplate.'components.shop')
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

@push('script')
<script>

    (function ($) {
        "use strict";
        $("#p_range").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [5, 10000],
            step: 1,
            slide: function (event, ui) {
                $("#min").val(ui.values[0]),
                $("#max").val(ui.values[1]);
                $("#minTxt").html(ui.values[0]),
                $("#maxTxt").html(ui.values[1]);
            },
            change:function(){
                    var min = $('input[name="min"]').val();
                    var max = $('input[name="max"]').val();

                    var categories   = [];
                    var searchValue = [];

                     getFilteredData(min,max,categories,searchValue)
                }
        });

        $("input[type='checkbox'][name='categories']").on('click', function(){
            var categories   = [];
            var searchValue = [];
            var min = [];
            var max = [];

                $('.filter-by-category:checked').each(function() {
                    if(!categories.includes(parseInt($(this).val()))){
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(min,max,categories,searchValue)
        });

        $("#searchValue").on('keyup', function () {
            var categories   = [];
            var searchValue = [];
            var min = [];
            var max = [];

            var searchValue = $(this).val();
            getFilteredData(min,max,categories,searchValue)
        });

        function getFilteredData(min,max,categories,searchValue){

            $.ajax({
                type: "get",
                url: "{{ route('product.filtered') }}",
                data:{
                    "min":min,
                    "max":max,
                    "categories": categories,
                    "search": searchValue,
                },
                dataType: "json",
                success: function (response) {
                    if(response.html){
                        $('.main-content').html(response.html);
                    }

                    if(response.error){
                        notify('error', response.error);
                    }
                }
            });
        }

    })(jQuery);

</script>
@endpush
