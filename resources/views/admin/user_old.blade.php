@extends('admin.app')

@section('content')
<div class="user-management-container">
    <!-- Header Section -->
    
    <!-- Table Container -->
    <div class="table-container">
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="user-id">#{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info">
                                <div class="phone">{{ $user->phone ?? 'No phone' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge role-{{ strtolower($user->user_role ?? 'user') }}">
                                {{ ucfirst($user->user_role ?? 'user') }}
                            </span>
                        </td>
                        <td>
                            <div class="location-info">
                                <div class="country">{{ $user->country ?? 'N/A' }}</div>
                                @if($user->state)
                                <div class="state">{{ $user->state }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="status-badge verified">
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>
                            @else
                                <span class="status-badge unverified">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Unverified
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#userModal_{{ $user->id }}"
                                        title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Enhanced User Detail Modal -->
                    <div class="modal fade" id="userModal_{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content modern-modal">
                                <div class="modal-header">
                                    <div class="modal-user-info">
                                        <div class="modal-avatar">
                                            <span>{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                                        </div>
                                        <div class="modal-user-details">
                                            <h5 class="modal-title">{{ $user->first_name }} {{ $user->last_name }}</h5>
                                            <span class="modal-subtitle">User ID: #{{ $user->id }}</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="user-details-grid">
                                        <div class="detail-group">
                                            <h6 class="detail-title">Personal Information</h6>
                                            <div class="detail-items">
                                                <div class="detail-item">
                                                    <span class="detail-label">Full Name</span>
                                                    <span class="detail-value">{{ $user->first_name }} {{ $user->last_name }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Email</span>
                                                    <span class="detail-value">{{ $user->email }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Phone</span>
                                                    <span class="detail-value">{{ $user->phone ?? 'Not provided' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="detail-group">
                                            <h6 class="detail-title">Account Information</h6>
                                            <div class="detail-items">
                                                <div class="detail-item">
                                                    <span class="detail-label">Role</span>
                                                    <span class="role-badge role-{{ strtolower($user->user_role ?? 'user') }}">
                                                        {{ ucfirst($user->user_role ?? 'user') }}
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Email Status</span>
                                                    @if($user->email_verified_at)
                                                        <span class="status-badge verified">
                                                            <i class="fas fa-check-circle"></i>
                                                            Verified on {{ $user->email_verified_at->format('M j, Y') }}
                                                        </span>
                                                    @else
                                                        <span class="status-badge unverified">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            Not verified
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Member Since</span>
                                                    <span class="detail-value">{{ $user->created_at->format('M j, Y g:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="detail-group">
                                            <h6 class="detail-title">Location</h6>
                                            <div class="detail-items">
                                                <div class="detail-item">
                                                    <span class="detail-label">Country</span>
                                                    <span class="detail-value">{{ $user->country ?? 'Not provided' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">State</span>
                                                    <span class="detail-value">{{ $user->state ?? 'Not provided' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">LGA</span>
                                                    <span class="detail-value">{{ $user->lga ?? 'Not provided' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($user->kyc_reference)
                                        <div class="detail-group">
                                            <h6 class="detail-title">KYC Information</h6>
                                            <div class="detail-items">
                                                <div class="detail-item">
                                                    <span class="detail-label">KYC Reference</span>
                                                    <span class="detail-value kyc-ref">{{ $user->kyc_reference }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Edit User</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Main Container */
.user-management-container {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header Styles */
.page-header {
background: linear-gradient(135deg, #FF4500 0%, #000000 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.stat-card {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    min-width: 160px;
}

.stat-icon {
    font-size: 2rem;
    margin-right: 1rem;
    opacity: 0.8;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Table Container */
.table-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
}

/* Modern Table Styles */
.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.modern-table thead {
    background: #f8fafc;
}

.modern-table th {
    padding: 1.5rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table td {
    padding: 1.25rem 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.modern-table tr:hover {
    background: #f9fafb;
    transition: background-color 0.2s ease;
}

/* User Info Styles */
.user-info {
    display: flex;
    align-items: center;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    margin-right: 0.75rem;
}

.user-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.user-email {
    font-size: 0.85rem;
    color: #6b7280;
}

.user-id {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #374151;
}

/* Badge Styles */
.role-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-admin {
    background: #fee2e2;
    color: #dc2626;
}

.role-user {
    background: #dbeafe;
    color: #2563eb;
}

.role-moderator {
    background: #fef3c7;
    color: #d97706;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge i {
    margin-right: 0.25rem;
    font-size: 0.7rem;
}

.verified {
    background: #d1fae5;
    color: #065f46;
}

.unverified {
    background: #fef2f2;
    color: #991b1b;
}

/* Location Info */
.location-info .country {
    font-weight: 500;
    color: #111827;
}

.location-info .state {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.1rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-view {
    background: #eff6ff;
    color: #2563eb;
}

.btn-view:hover {
    background: #dbeafe;
    transform: translateY(-1px);
}

.btn-edit {
    background: #f0fdf4;
    color: #16a34a;
}

.btn-edit:hover {
    background: #dcfce7;
    transform: translateY(-1px);
}

/* Modal Styles */
.modern-modal {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px 16px 0 0;
    padding: 2rem;
    border: none;
}

.modal-user-info {
    display: flex;
    align-items: center;
}

.modal-avatar {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
    margin-right: 1rem;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.modal-subtitle {
    opacity: 0.8;
    font-size: 0.9rem;
}

.btn-close-modal {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.btn-close-modal:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Modal Body */
.user-details-grid {
    display: grid;
    gap: 2rem;
}

.detail-group {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
}

.detail-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.detail-items {
    display: grid;
    gap: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
}

.detail-label {
    font-weight: 500;
    color: #6b7280;
    font-size: 0.9rem;
}

.detail-value {
    color: #111827;
    font-weight: 500;
}

.kyc-ref {
    font-family: 'Courier New', monospace;
    background: white;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.85rem;
}

/* Modal Footer */
.modern-modal .modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid #e5e7eb;
    background: #f8fafc;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

/* Responsive Design */
@media (max-width: 768px) {
    .user-management-container {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .modern-table th,
    .modern-table td {
        padding: 1rem 0.5rem;
    }
    
    .user-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .user-avatar {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection