@extends($activeTemplate . 'layouts.master')
@section('content')
<!-- ==================== Card Start Here ==================== -->
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4">
            <h2 class="text-center">Membership Checkout</h2>

            <div class="dashboard-card mb-4">
                <div class="dashboard-card-body">
                    <h4>{{ $plan->name }}</h4>
                    <p><strong>${{ number_format($plan->price, 2) }}</strong></p>
                    <ul>
                        <li>Access to all premium products</li>
                        <li>Download limit: {{ $plan->daily_download_limit }}/day</li>
                    </ul>
                </div>
            </div>
        
            <form method="POST" action="{{ route('user.pricing.pay') }}">
                @csrf     
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">          
                <button type="submit" class="btn btn--base">Purchase</button>
            </form>
        </div>


    </div>
</div>
<!-- ==================== Card End Here ==================== -->

@endsection
