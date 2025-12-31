@extends('admin.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-3">Users by Level</h1>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.users.levels') }}" class="btn btn-outline-secondary {{ is_null($level) ? 'active' : '' }}">All</a>
                        <a href="{{ route('admin.users.levels.low') }}" class="btn btn-outline-info {{ $level === 'low' ? 'active' : '' }}">Low ({{ $levelSummary->get('low')->total ?? 0 }})</a>
                        <a href="{{ route('admin.users.levels.medium') }}" class="btn btn-outline-warning {{ $level === 'medium' ? 'active' : '' }}">Medium ({{ $levelSummary->get('medium')->total ?? 0 }})</a>
                        <a href="{{ route('admin.users.levels.high') }}" class="btn btn-outline-success {{ $level === 'high' ? 'active' : '' }}">High ({{ $levelSummary->get('high')->total ?? 0 }})</a>
                        <a href="{{ route('admin.users.levels.market') }}" class="btn btn-outline-danger {{ $level === 'market_woman' ? 'active' : '' }}">Market Woman ({{ $levelSummary->get('market_woman')->total ?? 0 }})</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $level ? ucfirst($level) : 'All' }} Level Users</h5>
                    <span class="badge bg-primary">{{ $users->total() }} Total</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="my-table">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Level</th>
                                <th>KYC</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @php
                                            $levelColors = ['low'=>'info','mid'=>'warning','high'=>'success','market_woman'=>'danger'];
                                            $labels = ['market_woman'=>'Market Woman'];
                                        @endphp
                                        <span class="badge bg-{{ $levelColors[$user->level] ?? 'secondary' }}">{{ $labels[$user->level] ?? ucfirst($user->level ?? 'N/A') }}</span>
                                    </td>
                                    <td>
                                        @if($user->has_done_kyc === 'yes')
                                            <span class="badge bg-success">Done</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td><small>{{ optional($user->created_at)->format('M d, Y') }}</small></td>
                                    <td>
                                        <a href="{{ route('admin.users.view', $user->id) }}" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                    <div class="card-footer">{{ $users->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
