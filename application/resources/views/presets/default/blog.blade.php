@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- News Section -->
    <section class="news-section py-120 section-bg">
        <div class="container">
            @include($activeTemplate . 'components.blog')
            <div class="row mt-4">
                @if ($blogs->hasPages())
                    <div class="d-flex justify-content-end">
                        {{ paginateLinks($blogs) }}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- /News Section -->
@endsection
