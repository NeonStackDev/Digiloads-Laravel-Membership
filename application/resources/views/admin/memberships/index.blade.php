@extends('admin.layouts.app')

@section('panel')
@include('admin.components.tabs.user')
<div class="row">

    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('User')</th>
                                <th>@lang('Plan')</th>
                                <th>@lang('Start Date')</th>
                                <th>@lang('End Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Downloads Today')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($memberships as $membership)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                        <td>{{ $membership->user->username ?? 'N/A' }}</td>
                        <td>{{ $membership->plan->name ?? 'N/A' }}</td>
                        <td>{{ $membership->start_date }}</td>
                        <td>{{ $membership->end_date }}</td>
                        <td>
                            @if($membership->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($membership->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $membership->downloads_today }}</td>
                        <td>
                            @if($membership->status == 'pending')
                                <form action="{{ route('admin.memberships.approve', $membership->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.memberships.reject', $membership->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            @else
                                <em>—</em>
                            @endif
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
         @if ($memberships->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($memberships) }}
            </div>
            @endif  
        </div><!-- card end -->
    </div>


</div>

<x-confirmation-modal></x-confirmation-modal>
@endsection