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
                                <input type="text" name="search_table" class="form-control form--control bg--white"
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
                                <th>@lang('Date')</th>
                                <th>@lang('Order No')</th>
                                <th>@lang('Product')</th>
                                <th>@lang('File/External link')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($order->created_at) }}</td>
                                    <td data-label="@lang('Order No')" class="fw-bold">#{{ __($order->order_number) }}</td>
                                    <td data-label="@lang('Product')">

                                        @if (strlen(__(@$order->product->name)) > 20)
                                            {{ substr(__(@$order->product->name), 0, 20) . '...' }}
                                        @else
                                            {{ __(@$order->product->name) }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('File')">
                                        @if ($order->status == 1)
                                            @if ($order->product->file && !$order->product->external_link)
                                                <a class="btn btn--base btn--sm"
                                                    href="{{ route('user.product.file.download', ['id' => $order->product->id, 'orderId' => $order->id]) }}"
                                                    title="@lang('File Download')"><i class="fas fa-download"></i></a>
                                            @elseif(!$order->product->file && $order->product->external_link)
                                                <button class="btn btn--base btn--sm" title="External Link"><i
                                                        class="fas fa-link"></i></button>
                                            @else
                                                <a class="btn btn--base btn--sm"
                                                    href="{{ route('user.product.file.download', ['id' => $order->product->id, 'orderId' => $order->id]) }}"
                                                    title="@lang('File Download')"><i class="fas fa-download"></i></a>
                                                <button class="btn btn--base btn--sm copy-link-btn"
                                                    data-link="{{ $order->product->external_link }}"
                                                    title="External Link"><i class="fas fa-link"></i></button>
                                            @endif
                                        @else
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @endif
                                    </td>

                                    <td data-label="Amount">{{ $general->cur_sym }}{{ showAmount($order->price) }} </td>
                                    <td data-label="Status">@php echo $order->statusBadge($order->status) @endphp </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%" data-label="@lang('Order Table')">
                                        {{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($orders->hasPages())
                <div class="d-flex justify-content-end">
                    {{ paginateLinks($orders) }}
                </div>
            @endif
        </div>
    </div>
    </section>
    <!-- ==================== Card End Here ==================== -->
@endsection

@push('script')
    <script>
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




        // link copy
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.copy-link-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const link = this.getAttribute('data-link');
                    copyToClipboard(link);
                    Toast.fire({
                        icon: 'success',
                        title: 'Copied to link'
                    });
                });
            });
        });

        function copyToClipboard(text) {
            const tempInput = document.createElement('input');
            tempInput.style.position = 'absolute';
            tempInput.style.left = '-9999px';
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }
    </script>
@endpush
