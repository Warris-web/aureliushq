@extends('admin.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-3">Users by Employment Status</h1>

            <!-- Employment Status Filter Tabs -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.users.employment') }}" class="btn btn-outline-primary {{ is_null($status) ? 'active' : '' }}">
                            All Users
                        </a>
                        <a href="{{ route('admin.users.students') }}" class="btn btn-outline-primary {{ $status === 'Student' ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i> Students
                            <span class="badge bg-info">{{ $statusSummary->get('Student')->total ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.users.employed') }}" class="btn btn-outline-primary {{ $status === 'Employed' ? 'active' : '' }}">
                            <i class="fas fa-briefcase"></i> Employed
                            <span class="badge bg-success">{{ $statusSummary->get('Employed')->total ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.users.self_employed') }}" class="btn btn-outline-primary {{ $status === 'Self-Employed' ? 'active' : '' }}">
                            <i class="fas fa-user-tie"></i> Self-Employed
                            <span class="badge bg-warning">{{ $statusSummary->get('Self-Employed')->total ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.users.unemployed') }}" class="btn btn-outline-primary {{ $status === 'Unemployed' ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Unemployed
                            <span class="badge bg-secondary">{{ $statusSummary->get('Unemployed')->total ?? 0 }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $status ?? 'All' }} Users</h5>
                    <span class="badge bg-primary">{{ $users->total() }} Total</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Employment Status</th>
                                <th>School/Student ID</th>
                                <th>KYC Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'Student' => 'info',
                                                'Employed' => 'success',
                                                'Self-Employed' => 'warning',
                                                'Unemployed' => 'secondary',
                                            ];
                                            $statusIcons = [
                                                'Student' => 'fa-graduation-cap',
                                                'Employed' => 'fa-briefcase',
                                                'Self-Employed' => 'fa-user-tie',
                                                'Unemployed' => 'fa-user',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$user->employee_status] ?? 'secondary' }}">
                                            <i class="fas {{ $statusIcons[$user->employee_status] ?? 'fa-user' }}"></i>
                                            {{ $user->employee_status ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->employee_status === 'Student')
                                            <div>
                                                <strong>School:</strong> {{ $user->school_name ?? 'N/A' }}<br>
                                                @if($user->student_id)
                                                    <a href="{{ asset($user->student_id) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                        <i class="fas fa-file-alt"></i> View ID
                                                    </a>
                                                @else
                                                    <span class="text-muted">No ID uploaded</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->has_done_kyc === 'yes')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $user->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.view', $user->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        No users found for this employment status.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
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
    .btn-group .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endsection
