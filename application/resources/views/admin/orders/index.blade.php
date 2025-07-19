
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
                                <th>@lang('Date')</th>
                                <th>@lang('Order No')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                           <tr>
                            <td>{{ showDateTime($order->created_at)}}</td>
                            <td>#{{__($order->order_number)}}</td>
                            <td>{{@$order->user->fullname}}</td>
                            <td>{{$general->cur_sym}}{{showAmount($order->price)}}</td>
                            <td>@php echo $order->statusBadge($order->status) @endphp</td>
                            <td>
                                <a href="{{route('admin.orders.details',$order->id)}}" class="btn btn-sm btn--primary ms-1"> <i class="la la-eye"></i>
                                </a>
                            </td>
                         </tr>
                         @empty
                         <tr>
                           <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                        </tr>
                         @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($orders->hasPages())
            <div class="card-footer py-4">
             @php echo paginateLinks($orders) @endphp
         </div>
         @endif
        </div><!-- card end -->
    </div>
</div>
@endsection


