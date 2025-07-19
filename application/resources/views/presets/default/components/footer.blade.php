@php
    $links = getContent('policy_pages.element');
    $importantLinks = getContent('footer_important_links.element', false, null, true);
    $companyLinks = getContent('footer_company_links.element', false, null, true);
    $subscribe = getContent('subscribe.content', true);
    $contact = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $user = auth()->user();
    $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
@endphp
<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area ">
    <div class="py-120">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{ route('home') }}" class="footer-logo-normal" id="footer-logo-normal">
                                <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                                    alt="{{ config('app.name') }}">
                            </a>
                            <a href="{{ route('home') }}" class="footer-logo-dark hidden" id="footer-logo-dark">
                                <img src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                                    alt="{{ config('app.name') }}">
                            </a>
                        </div>
                        <p class="footer-item__desc">{{ __($contact->data_values->short_description) }}</p>

                        <ul class="social-list">
                            @foreach ($socialIcons as $item)
                                <li class="social-list__item"><a href="{{ __($item->data_values->url) }}"
                                        class="social-list__link" target="_blank">@php echo $item->data_values->social_icon @endphp</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Important Link')</h5>
                        <ul class="footer-menu">
                            @foreach ($importantLinks as $key => $item)
                                <li class="footer-menu__item"><a href="{{ url('/') . $item->data_values->url }}"
                                        class="footer-menu__link">{{ __($item->data_values->title) }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Newsletter')</h5>
                        <p class="footer-item__desc mb-3">{{ __($subscribe->data_values->sub_heading) }}</p>
                        <form class="footer-subscribe-box" action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <input type="text" class="form--input__field search-form--control" name="email"
                                placeholder="@lang('Enter your mail')...">
                            <button class="search-btn" type="submit">@lang('Subscribe')</button>
                        </form>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Address')</h5>
                        <ul class="footer-menu">

                            <li class="footer-menu__item"><span class=""><i class="fas fa-map-marker-alt"></i>
                                    {{ __($contact->data_values->contact_details) }}</span></li>
                            <li class="footer-menu__item"><span class=""><i class="fas fa-phone-alt"></i>
                                    {{ __($contact->data_values->contact_number) }}</span></li>
                            <li class="footer-menu__item"><span class=""><i class="far fa-envelope"></i>
                                    {{ __($contact->data_values->email_address) }}</span></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End-->

    <!-- bottom Footer -->
    <div class="bottom-footer section-bg py-3">
        <div class="container">
            <div class="row gy-2">
                <div class="col-lg-6 col-md-12">
                    <div class="bottom-footer-text"> @php echo $contact->data_values->website_footer @endphp</div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="bottom-footer-menu">
                        <ul>
                            @foreach ($links as $link)
                                <li><a href="{{ route('policy.pages', [slug($link->data_values->title), $link->id]) }}"
                                        target="_blank">{{ __($link->data_values->title) }}</a></li>
                            @endforeach
                            <li><a href="{{ url('/cookie-policy') }}" target="_blank">@lang('Cookie Policy')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ==================== Footer End Here ==================== -->

<div class="bottom_bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bottonAppBar">
                    <div class="tapTo-hom">
                        <div class="tap-box">
                            <a href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                            </a>
                        </div>
                    </div>

                    <div class="bottom-item">
                        <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                            aria-controls="offcanvasExample">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>

                    <div class="bottom-item">
                        <a href="{{ route('browse') }}">
                            <i class="fab fa-product-hunt"></i>
                        </a>
                    </div>

                    <div class="bottom-item">
                        <a href="{{ url('blog') }}">
                            <i class="fas fa-rss-square"></i>
                        </a>
                    </div>

                    <div class="bottom-item">
                        <a href="{{ route('contact') }}">
                            <i class="fas fa-address-book"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="scroll-top show">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
            style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 197.514;">
        </path>
    </svg>
    <i class="fas fa-arrow-up"></i>
</div>

<!-- footer -->
