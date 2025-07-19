@php
    $contact = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $languages = App\Models\Language::all();
    $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
    $user = auth()->user();
@endphp
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="top-header-wrapper">
                    <div class="top-contact">
                        <ul class="login-registration-list">
                            <li class="login-registration-list__item">
                                <ul class="social-list">
                                    @foreach ($socialIcons as $item)
                                        <li class="social-list__item"><a href="{{ __($item->data_values->url) }}"
                                                class="social-list__link" target="_blank">@php echo $item->data_values->social_icon @endphp</a> </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="top-button">
                        <ul class="login-registration-list d-flex flex-wrap justify-content-between align-items-center">
                            @auth
                                <li class="login-registration-list__item"><span
                                        class="login-registration-list__icon"></span><a href="{{ route('user.logout') }}"
                                        class="login-registration-list__link"><i
                                            class="fas fa-sign-out-alt"></i>@lang('Logout')</a></li>
                            @else
                                <li class="login-registration-list__item"><span
                                        class="login-registration-list__icon"></span><a href="{{ route('user.login') }}"
                                        class="login-registration-list__link"><i
                                            class="fas fa-sign-in-alt"></i>@lang('Login')</a></li>
                            @endauth
                        </ul>
                        <div class="language-box">
                            <select class="langSel select">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->code }}"
                                        @if (Session::get('lang') === $language->code) selected @endif>{{ __($language->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header" id="header">
        <div class="container position-relative">
            <div class="row">
                <div class="header-wrapper">
                    <!-- ham menu -->
                    <i class="fas fa-bars ham__menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample"></i>

                    <!-- logo -->
                    <div class="header-menu-wrapper align-items-center d-flex">
                        <div class="logo-wrapper">
                            <a href="{{ route('home') }}" class="normal-logo"> <img
                                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                                    alt="{{ config('app.name') }}"></a>

                            <a href="{{ route('home') }}" class="dark-logo hidden"> <img
                                    src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                                    alt="{{ config('app.name') }}"></a>
                        </div>
                    </div>
                    <!-- / logo -->

                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            @auth
                                <li>
                                    <a class="{{ Route::is('user.home') ? 'active' : '' }}" aria-current="page"
                                        href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                            @endauth
                            @foreach ($pages as $page)
                                @if ($page->slug != 'blog')
                                    <li><a class="{{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}"
                                            aria-current="page"
                                            href="{{ route('pages', [$page->slug]) }}">{{ __($page->name) }}</a>
                                @endif
                            @endforeach
                        </ul>
                        <div class="menu-right-wrapper">
                            <ul>
                                <li>
                                    <div class="light-dark-btn-wrap ms-1" id="light-dark-checkbox">
                                        <i class="fas fa-moon mon-icon"></i>
                                        <i class='fas fa-sun sun-icon'></i>
                                    </div>
                                </li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--========================== Header section End ==========================-->

<!--========================== Sidebar mobile menu wrap Start ==========================-->


<div class="offcanvas offcanvas-start text-bg-light" tabindex="-1" id="offcanvasExample">
    <div class="offcanvas-header">
        <div class="logo">
            <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="{{ route('home') }}" class="normal-logo"> <img
                            src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                            alt="{{ config('app.name') }}"></a>
                    <a href="{{ route('home') }}" class="dark-logo hidden"> <img
                            src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                            alt="{{ config('app.name') }}"></a>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @auth
            <div class="user-info"
                style="background: url({{ asset($activeTemplateTrue . 'images/sidenav_uer.jpg') }});background-position: center;background-size: cover; filter: grayscale(30%) ;">
                <div class="user-thumb">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                        alt="user-image">
                </div>
                <h4 class="text-white">{{ __($user->fullname) }}</h4>
            </div>
        @endauth

        <ul class="side-Nav">
            @auth
                <li class="{{ Route::is('user.home') ? 'active' : '' }}">
                    <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                </li>
            @endauth
            @foreach ($pages as $page)
                <li class="{{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}">
                    <a href="{{ route('pages', [$page->slug]) }}"> {{ __($page->name) }}</a>
                </li>
            @endforeach
            @auth
                <li>
                    <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                </li>
            @else
                <li class="{{ Route::is('user.login') ? 'active' : '' }}">
                    <a href="{{ route('user.login') }}">@lang('Login')</a>
                </li>
            @endauth
        </ul>

    </div>
</div>
