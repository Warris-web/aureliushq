@extends('admin.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-3">Active Users</h1>
            <p class="text-muted">Users who have completed both KYC verification and onboarding payment</p>

            <!-- Summary Stats Card -->
            {{-- <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-0">Active Users</h6>
                                    <h2 class="text-white mb-0">{{ $totalActiveUsers }}</h2>
                                </div>
                                <div class="fs-1">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-0">Total Users</h6>
                                    <h2 class="text-white mb-0">{{ $totalUsers }}</h2>
                                </div>
                                <div class="fs-1">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-0">Activation Rate</h6>
                                    <h2 class="text-white mb-0">{{ $totalUsers > 0 ? round(($totalActiveUsers / $totalUsers) * 100, 1) : 0 }}%</h2>
                                </div>
                                <div class="fs-1">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Search and Filter Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.active') }}">
                        <div class="row g-3">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone, or ID..." value="{{ $search }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Active Users List</h5>
                    <span class="badge bg-success">{{ $users->total() }} Total Active Users</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="active-users-table">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Level</th>
                                <th>Location</th>
                                <th>KYC Status</th>
                                <th>Onboarding Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>#{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $levelColors = [
                                                'low' => 'info',
                                                'mid' => 'warning',
                                                'high' => 'success',
                                                'market_woman' => 'danger'
                                            ];
                                            $labels = ['market_woman' => 'Market Woman'];
                                            $level = $user->level ?? 'N/A';
                                        @endphp
                                        <span class="badge bg-{{ $levelColors[$level] ?? 'secondary' }}">
                                            {{ $labels[$level] ?? ucfirst($level) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->state)
                                            <small>{{ $user->state }}<br>{{ $user->country ?? '' }}</small>
                                        @else
                                            <small class="text-muted">N/A</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Paid
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ optional($user->created_at)->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.view', $user->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <p>No active users found</p>
                                            @if($search)
                                                <a href="{{ route('admin.users.active') }}" class="btn btn-sm btn-primary">Clear Search</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    height: 40px;
    width: 40px;
}

.avatar-title {
    align-items: center;
    display: flex;
    font-weight: 500;
    height: 100%;
    justify-content: center;
    width: 100%;
}

.bg-soft-primary {
    background-color: rgba(114, 124, 245, 0.18);
}

.text-primary {
    color: #727cf5 !important;
}

.rounded-circle {
    border-radius: 50% !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Add DataTables initialization if you want sorting, filtering etc.
    // $('#active-users-table').DataTable({
    //     "pageLength": 50,
    //     "order": [[0, "desc"]]
    // });
});
</script>
@endsection
