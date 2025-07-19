@php
    $blog = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp
<!-- News Section -->
<section class="news-section py-120 section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center hero-content">
                <h2 class="pb-40">{{ __(@$blog->data_values->heading) }}</h2>
                <p class="pb-80">{{ __(@$blog->data_values->sub_heading) }}</p>
            </div>
        </div>
        @include($activeTemplate . 'components.blog')
    </div>
</section>
<!-- /News Section -->
