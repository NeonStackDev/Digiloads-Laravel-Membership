@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- ==================== Card Start Here ==================== -->
    <div class="col-xl-9 col-lg-12">
        <div class="dashboard-body account-form">
            <div class="dashboard-body__bar">
                <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap justify-content-end mb-3">
                        <div class="d-inline">
                            <div class="input-group justify-content-end">
                                <input type="text" name="search_table" class="form--control form-control bg--white"
                                    placeholder="@lang('Search')...">
                                <button class="btn btn--base input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <h4>{{ __($pageTitle) }}</h4>
                <div class="card-wrap pb-30">
                    <table class="table table--responsive--lg custom-table">
                        <thead>
                            <tr>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Image')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Discount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td data-label="Product Name"><a
                                            href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}"
                                            target="_blank">{{ __($product->name) }}</a></td>
                                    <td data-label="Category"><a
                                            href="{{ route('filter.category.products', $product->category->id) }}"
                                            target="_blank">{{ __($product->category->name) }}</a></td>
                                    <td data-label="Image"><a
                                            href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id]) }}"><img
                                                src="{{ getImage(getFilePath('productThumbnail') . '/' . @$product->thumbnail) }}"
                                                alt="Image" class="rounded" style="width:100px;"></a></td>
                                    <td data-label="Price">{{ __($general->cur_sym) }} {{ __(showAmount($product->price)) }}
                                    </td>
                                    <td data-label="Discount">
                                        @if (isset($product->discount))
                                            {{ __($product->discount) }}%
                                        @else
                                            <span>@lang('No')</span>
                                        @endif
                                    </td>
                                    <td data-label="Status">@php echo $product->statusBadge($product->status); @endphp</td>
                                    <td data-label="Action">
                                        <a href="{{ route('user.product.edit', $product->id) }}"
                                            class="btn btn--base btn--sm outline" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                        <button class="btn btn--base btn--sm btn--danger outline rejectBtn" title="Delete"
                                            data-id="{{ $product->id }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%" data-label="Product Table">
                                        {{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            @if ($products->hasPages())
                <div class="d-flex justify-content-end">
                    {{ paginateLinks($products) }}
                </div>
            @endif
        </div>
    </div>
    </section>
    <!-- ==================== Card End Here ==================== -->


    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Product Delete Confirmation')</h5>
                    <button type="button" class="close btn btn--danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.product.delete') }}" method="get">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to delete this product?')
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="buttorn_wrapper">
                            <button type="submit" class="btn btn--base"> <span class="btn_title">@lang('Delete') <i
                                        class="fa-solid fa-angles-right"></i></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            
            $('.custom-table').css('padding-top', '0px');
            var tr_elements = $('.custom-table tbody tr');

            $(document).on('input', 'input[name=search_table]', function() {
                "use strict";

                var search = $(this).val().toUpperCase();
                var match = tr_elements.filter(function(idx, elem) {
                    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
                }).sort();
                var table_content = $('.custom-table tbody');
                if (match.length == 0) {
                    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
                } else {
                    table_content.html(match);
                }
            });

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
