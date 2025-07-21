@extends($activeTemplate . 'layouts.frontend')
@section('content')
<!-- ==================== Card Start Here ==================== -->
<div class="container">
    <div class="dashboard-body">
         <!-- ==================== Notifications ==================== -->
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session()->has('notify'))       
            @foreach(session('notify') as $msg)
                <div class="alert alert-{{ $msg[0] }} alert-dismissible fade show" role="alert">
                    {{ $msg[1] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <!-- ==================== End Notifications ==================== -->
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4">
            @foreach($plans as $plan)           
                <div class="col-md-4">
                    <div class="dashboard-card mb-4 shadow ">
                        <div class="dashboard-card-body membership-card  {{($membership && $plan->id == $membership->plan_id) ? 'membership-card-active' : 'membership-card'}}">                            
                            <h5 class="dashboard-card__title">{{ $plan->name }}</h5>
                            <h3 class="dashboard-card__title">${{ $plan->price }}</h3>                            
                            <ul class="list-unstyled">         
                            <li>Access to all premium products</li>
                            <li>Regular Updates</li>
                            <li>No Auto-Renewal</li>
                            <li>Standard Support</li>
                            <li>Access to All Products </li>                            
                            <li>Download limit: {{ $plan->daily_download_limit }}/day</li>
                            </ul>
                            <a href=" {{($membership && $plan->id == $membership->plan_id) ? '' : route('pricing.checkout', $plan->id)}}" class="d-block ">
                                <button class="btn btn--base  {{($membership && $plan->id == $membership->plan_id) ? 'disabled' : ''}}">@lang('Choose Plan')</button>
                            </a>
                        </div>
                    </div>
                </div>         
            @endforeach
        </div>
    </div>
</div>
<!-- ==================== Card End Here ==================== -->
@endsection
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.classList.remove('show');
        });
    }, 4000); // hides after 4 seconds
</script>