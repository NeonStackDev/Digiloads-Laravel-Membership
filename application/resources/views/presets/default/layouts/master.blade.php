<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('includes.seo')
    <!-- CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/odometer.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    @stack('style-lib')
    @stack('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>
<body>


    <!--==================== Preloader Start ====================-->
    <div id="loading">
        <div id="loading-center">
            <span class="loader"></span>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

@include($activeTemplate.'components.header')

@if(request()->route()->uri != '/')
 @include($activeTemplate.'components.breadcrumb')
 @endif

<!-- ==================== Dashboard Start Here ==================== -->
<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            @include($activeTemplate.'components.side_nav')
            @yield('content')
        </div>
    </div>
</div>

@include($activeTemplate.'components.cookie')
@include($activeTemplate.'components.footer')


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/common/js/jquery-3.7.1.min.js')}}"></script>
  <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/slick.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/jquery.appear.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/swiper-bundle.min.js')}}"></script>
 <script src="{{asset($activeTemplateTrue.'js/rangeSlider.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/vanilla-tilt.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/moment.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

@stack('script-lib')

@stack('script')

@include('includes.plugins')

@include('includes.notify')


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });


        var inputElements = $('input,select');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });



    })(jQuery);
</script>

</body>
</html>
