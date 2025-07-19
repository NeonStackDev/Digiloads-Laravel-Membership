@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30 justify-content-center">
    <div class="col-xl-12 col-md-12 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 p-2 text-muted">@lang('Shipping Address')</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Order Number')
                        <span class="fw-bold  badge badge--success">#{{@$orderDetails->order_number}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('User')
                        <span class="fw-bold">{{@$orderDetails->user->fullname}}</span>
                    </li>
                    
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Email')
                        <span class="fw-bold">
                            <a>{{@$orderDetails->user->email}}</a>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Phone Number')
                        <span class="fw-bold">{{@$orderDetails->user->mobile}}</span>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('Product Image')</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Price')</th>
                            </tr>
                        </thead>
                        <tbody>
                 
                           <tr>
                              <td><img src="{{ getImage(getFilePath('productImage').'/'.@$orderDetails->product->productImages[0]->image)}}" alt="Image" class="rounded" style="width:50px;"></td>

                              <td>
                                {{__($orderDetails->product->name)}}
                            </td>
                           
                            <td>
                                {{__($general->cur_sym)}}{{showAmount($orderDetails->price)}}
                            </td>
                           </tr>
                
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


