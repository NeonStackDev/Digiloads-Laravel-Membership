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
                                <th>@lang('Price')</th>
                                <th>@lang('Daily Download Limit')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTable">
                            @forelse ($membershipplans as $key=>$item)
                            <tr data-id="{{ $item->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ __($item->name) }}</td>
                                <td>{{ __($item->price) }}</td>
                                <td>{{ __($item->daily_download_limit) }}</td>
                                <td>
                                    <div class="button--group">
                                        <button type="button"
                                            class="btn btn-sm btn--primary updateMembership" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}" data-limit="{{ $item->daily_download_limit }}"
                                            data-price="{{ $item->price }}"><i class="las la-edit"></i></button>
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

        </div><!-- card end -->
    </div>
</div>


{{-- Add METHOD MODAL --}}
<div id="addMembership" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Add Memebership')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.memberships.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('Name'):</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Name')..."
                            required>
                    </div>
                    <div class="form-group">
                        <label for="icon">@lang('Price'):</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="price" placeholder="@lang('Price')...">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="icon">@lang('Duration Days'):</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="duration_days" placeholder="@lang('Duration Days')...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name"> @lang('Limit'):</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="limit" placeholder="@lang('Daily Download Limit')...">
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
<div id="updateMembership" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Memebership')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.memberships.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name"> @lang('Name'):</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Name')...">
                    </div>
                    <div class="form-group">
                        <label for="icon">@lang('Price'):</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="price" placeholder="@lang('Price')...">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="name"> @lang('Limit'):</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="limit" placeholder="@lang('Daily Download Limit')...">
                        </div>
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
<button type="button" class="btn btn-sm btn--primary addMembership"><i
        class="las la-plus"></i>@lang('Add New')</button>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";

        $('.addMembership').on('click', function() {
            $('#addMembership').modal('show');
        });

        // update modal anad existing data show
        $('.updateMembership').on('click', function() {
            var modal = $('#updateMembership');
            console.log($(this));

            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=price]').val(($(this).data('price')));
            modal.find('input[name=limit]').val(Number($(this).data('limit')));

            // Update the icon preview in the span element


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