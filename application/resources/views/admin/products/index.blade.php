@extends('admin.layouts.app')
@section('panel')
    <div class="d-flex flex-wrap justify-content-end mb-3">
        <div class="d-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search_table" class="form-control bg--white" placeholder="@lang('Search')...">
                <button class="btn btn--primary input-group-text"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
    @include('admin.components.tabs.product')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Author')</th>
                                    <th>@lang('Thumbnail')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Discount')</th>
                                    <th>@lang('File Check')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $item)
                                    <tr>
                                        <td>{{ __($item->name) }}</td>
                                        <td>{{ __(@$item->category->name) }}</td>
                                        <td>
                                            @if ($item->user)
                                                <span class="bage badge--warning">{{ @$item->user->username }}</span>
                                            @else
                                                <span class="bage badge--primary">@lang('Admin')</span>
                                            @endif
                                        </td>

                                        <td><img src="{{ getImage(getFilePath('productThumbnail') . '/' . @$item->thumbnail) }}" alt="@lang('Image')" class="rounded img-thumbnail" style="width:100px;"></td>

                                        <td>
                                            {{ $general->cur_sym }}{{ showAmount($item->price) }}
                                        </td>
                                        <td>
                                            @if (isset($item->discount))
                                                {{ $item->discount }}%
                                            @else
                                                <span>@lang('No')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn--primary btn--sm"
                                                    href="{{ route('admin.product.file.download',$item->id) }}"
                                                    title="@lang('File Download')"><i class="fas fa-download"></i></a>
                                        </td>
                                        <td>@php echo $item->statusBadge($item->status); @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.product.edit', $item->id) }}"
                                                    class="btn btn-sm btn--primary"><i class="las la-edit"></i></a>
                                                <button class="btn btn-sm btn--danger rejectBtn"
                                                    data-id="{{ $item->id }}"><i class="las la-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($products->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($products) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

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
                <form action="{{ route('admin.product.delete') }}" method="get">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to delete this product?')
                        </p>
                    </div>
                    <div class="modal-footer">
                        <div class="buttorn_wrapper">
                            <button type="submit" class="btn btn--danger"> @lang('Delete')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn--primary "><i class="las la-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
