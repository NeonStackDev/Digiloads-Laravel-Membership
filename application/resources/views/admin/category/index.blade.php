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
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('S/N')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTable">
                                @forelse ($categories as $key=>$item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ __($item->name) }}</td>
                                        <td>
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button"
                                                    class="btn btn-sm btn--primary updateCategory"data-id="{{ $item->id }}"
                                                    data-name="{{ $item->name }}" data-status="{{ $item->status }}"
                                                    data-icon="{{ $item->icon }}"><i class="las la-edit"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-message">
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>


    {{-- Add METHOD MODAL --}}
    <div id="addCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">@lang('Name'):</label>
                            <input type="text" class="form-control" name="name" placeholder="@lang('Name')..."
                                required>
                        </div>
                        <div class="form-group">
                            <label for="icon">@lang('Icon'):</label>
                            <div class="input-group">
                                <input type="text" class="form-control iconPicker icon" autocomplete="off" name="icon"
                                    placeholder="@lang('Icone')..." required>
                                <span class="input-group-text  input-group-addon" data-icon="las la-home" role="iconpicker">
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Update METHOD MODAL --}}
    <div id="updateCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Update Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.category.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name"> @lang('Name'):</label>
                            <input type="text" class="form-control" name="name" placeholder="@lang('Name')...">
                        </div>
                        <div class="form-group">
                            <label for="icon">@lang('Icon'):</label>
                            <div class="input-group">
                                <input type="text" class="form-control iconPicker icon" autocomplete="off" name="icon"
                                    placeholder="@lang('Icone')..." required>
                                <span class="input-group-text  input-group-addon icon-preview" data-icon="las la-home"
                                    role="iconpicker"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name"> @lang('Status'):</label>
                            <select name="status" class="form-control">
                                <option value="0" {{ @$item->status == 0 ? 'selected' : '' }}>@lang('Inactive')
                                </option>
                                <option value="1" {{ @$item->status == 1 ? 'selected' : '' }}>@lang('Active')
                                </option>

                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn--primary addCategory"><i
            class="las la-plus"></i>@lang('Add New')</button>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addCategory').on('click', function() {
                $('#addCategory').modal('show');
            });

            // update modal anad existing data show
            $('.updateCategory').on('click', function() {
                var modal = $('#updateCategory');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=icon]').val($(this).data('icon'));

                var statusValue = $(this).data('status');
                modal.find('select[name=status]').val(statusValue);

                // Update the icon preview in the span element
                var icon = $(this).data('icon');
                modal.find('.icon-preview').html(icon);

                modal.modal('show');
            });

            // icone picker
            $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                $(this).closest('.form-group').find('.iconpicker-input').val(
                    `<i class="${e.iconpickerValue}"></i>`);
            });

        })(jQuery);
    </script>
@endpush
