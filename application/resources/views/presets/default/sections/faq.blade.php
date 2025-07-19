@php
    $faq = getContent('faq.content', true);
    $faqs = getContent('faq.element', false, 12);
@endphp
<!--  Faq -->
<section class="faq-section  py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center hero-content">
                <h2 class="pb-40">{{ __($faq->data_values->heading) }}</h2>
                <p class="pb-80">{{ __($faq->data_values->sub_heading) }}</p>
            </div>
        </div>
        <div class="row pt-1">
            <div class="col-lg-6">
                <div class="accordion custom--accordion" id="accordionExample">
                    {{-- Display even indices first --}}
                    @foreach ($faqs as $index => $item)
                        @if ($index % 2 == 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                                        {{ __(@$item->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}"
                                    class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @php echo @$item->data_values->answer; @endphp
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="accordion custom--accordion" id="accordionExample2">
                    {{-- Display odd indices next --}}
                    @foreach ($faqs as $index => $item)
                        @if ($index % 2 != 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index == 1 ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}"
                                        aria-expanded="{{ $index == 1 ? 'true' : 'false' }}">
                                        {{ __($item->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}"
                                    class="accordion-collapse collapse {{ $index == 1 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        @php echo $item->data_values->answer; @endphp
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Faq -->
