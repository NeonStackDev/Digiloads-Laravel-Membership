@extends($activeTemplate.'layouts.master')
@section('content')
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body account-form deposit">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6 col-md-12">
                <form action="">
                    <div class="mb-3 ">
                        <div class="input-group deposit-top-search">
                            <input type="text" name="search" class="form--control" value="" placeholder="Search by transactions" id="search">
                            <button class="btn btn--base btn--sm detailBtn" type="submit">
                                <i class="las la-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-0">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th data-label="Gateway">@lang('Gateway')</th>
                            <th data-label="Initiated" class="text-center">@lang('Initiated')</th>
                            <th data-label="Amount" class="text-center">@lang('Amount')</th>
                            <th data-label="Conversion" class="text-center">@lang('Conversion')</th>
                            <th data-label="Status" class="text-center">@lang('Status')</th>
                            <th data-label="Action">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($withdraws as $withdraw)
                        <tr>
                            <td>
                                <span class="fw-bold"><span class="text-primary"> {{
                                        __(@$withdraw->method->name) }}</span></span>
                            </td>
                            <td class="text-center">
                                {{ showDateTime($withdraw->created_at) }}
                            </td>
                            <td class="text-center">
                                {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount ) }}
                            </td>
                            <td class="text-center">

                                <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency)}}</strong>
                            </td>
                            <td class="text-center">
                                @php echo $withdraw->statusBadge @endphp
                            </td>
                            <td>
                                <button class="btn btn--sm btn--base detailBtn outline"
                                    data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                    @if($withdraw->status == 3)
                                    data-admin_feedback="{{ $withdraw->admin_feedback }}"
                                    @endif >
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%" data-label="Withdraw Table">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
        @if($withdraws->hasPages())
        <div class="card-footer text-end">
            {{$withdraws->links()}}
        </div>
        @endif
        </div>
    </div>

</div>



{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData">

                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');
            var userData = $(this).data('user_data');
            var html = ``;
            userData.forEach(element => {
                if (element.type != 'file') {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                }
            });
            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);

            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush
