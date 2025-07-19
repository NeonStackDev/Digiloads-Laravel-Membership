@extends($activeTemplate.'layouts.master')
@section('content')
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4">
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a class="d-block" href="{{route('user.orders')}}">
                    <div class="dashboard-card">
                        <span class="banner-effect-1"></span>
                        <div class="dashboard-card__icon">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                        <div class="dashboard-card__content">
                            <h5 class="dashboard-card__title">@lang('My Orders')</h5>
                            <h4 class="dashboard-card__amount">{{__($ordersCount)}}</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Balance')</h5>
                        <h4 class="dashboard-card__amount">{{__($general->cur_sym)}} {{showAmount($userBalace)}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a class="d-block" href="{{route('user.product.index')}}">
                    <div class="dashboard-card">
                        <span class="banner-effect-1"></span>
                        <div class="dashboard-card__icon">
                            <i class="fab fa-product-hunt"></i>
                        </div>
                        <div class="dashboard-card__content">
                            <h5 class="dashboard-card__title">@lang('My Products')</h5>
                            <h4 class="dashboard-card__amount">{{__($productCount)}}</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Monthly Deposit & Withdraw Report') (@lang('This year'))</h5>
                        <div id="account-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script src="{{asset('assets/admin/js/apexcharts.min.js')}}"></script>

<script>
    "use strict";
    // [ account-chart ] start
    (function () {
        var options = {
            chart: {
                type: 'area',
                stacked: false,
                height: '310px'
            },
            stroke: {
                width: [0, 3],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            colors: ['#00adad', '#67BAA7'],
            series: [{
                name: '@lang("Withdrawals")',
                type: 'column',
                data: @json($withdrawalsChart['values'])
    }, {
        name: '@lang("Deposits")',
        type: 'area',
        data: @json($depositsChart['values'])
    }],
    fill: {
        opacity: [0.85, 1],
                },
    labels: @json($depositsChart['labels']),
    markers: {
        size: 0
    },
    xaxis: {
        type: 'text'
    },
    yaxis: {
        min: 0
    },
    tooltip: {
        shared: true,
            intersect: false,
                y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return "$ " + y.toFixed(0);
                }
                return y;

            }
        }
    },
    legend: {
        labels: {
            useSeriesColors: true
        },
        markers: {
            customHTML: [
                function () {
                    return ''
                },
                function () {
                    return ''
                }
            ]
        }
    }
            }
    var chart = new ApexCharts(
        document.querySelector("#account-chart"),
        options
    );
    chart.render();
        }) ();

</script>
@endpush

