<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.product.index') ? 'active' : '' }}"
                    href="{{route('admin.product.index')}}">@lang('Active')
                    @if($totalProduct)
                    <span class="badge rounded-pill bg--white text-muted">{{$totalProduct}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.product.pending') ? 'active' : '' }}"
                    href="{{route('admin.product.pending')}}">@lang('Pending')
                    @if($pendingProduct)
                    <span class="badge rounded-pill bg--white text-muted">{{$pendingProduct}}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.product.approve') ? 'active' : '' }}"
                    href="{{route('admin.product.approve')}}">@lang('Approve')
                    @if($approveProduct)
                    <span class="badge rounded-pill bg--white text-muted">{{$approveProduct}}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
