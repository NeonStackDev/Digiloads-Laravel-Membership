<div class="row pt-1 gy-5 nws-card_wraper justify-content-center">
    @foreach ($blogs as $item)
        <div class="col-lg-4 col-md-6">
            <div class="nws-card_body">
                <div class="card-img">
                    <a
                        href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                        <img src="{{ getImage(getFilePath('blog') . '/' . 'thumb_' . $item->data_values->blog_image) }}"
                            alt="blog image">
                    </a>
                </div>
                <div class="card-item">
                    <div class="date">
                        <p>{{ showDateTime($item->created_at) }}</p>
                    </div>
                    <div class="nws-title pt-3">
                        <a
                            href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                            <h4>
                                @if (strlen(__($item->data_values->title)) > 50)
                                    {{ substr(__($item->data_values->title), 0, 50) . '...' }}
                                @else
                                    {{ __($item->data_values->title) }}
                                @endif
                            </h4>
                        </a>
                    </div>

                    <div class="py-2">
                        <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}"
                            class="btn btn--base">{{ __($item->data_values->blog_btn) }} <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
