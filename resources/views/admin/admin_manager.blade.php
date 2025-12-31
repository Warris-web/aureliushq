@extends('admin.app')

@section('content')
<style>
/* ====== Theme Colors (Bright) ====== */
:root {
  --primary-color: #ff8c00; /* orange accent */
  --secondary-color: #333;  /* text color */
  --light-bg: #ffffff;      /* white */
  --border-color: #e5e5e5;  /* soft border */
  --hover-bg: #fff7ec;      /* light orange tint */
}

/* ====== Layout ====== */
body {
  background-color: #f8f9fb !important;
  color: var(--secondary-color);
}

.card {
  border: 1px solid var(--border-color);
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  background: var(--light-bg);
}
.card-header {
  border-bottom: 2px solid var(--primary-color);
  color: var(--primary-color);
  font-weight: 600;
  background-color: #fffdfb;
}

/* ====== Table ====== */
.table thead {
  background-color: #f7f7f7;
  color: var(--secondary-color);
}
.table tbody tr {
  border-bottom: 1px solid var(--border-color);
}
.table tbody tr:hover {
  background-color: var(--hover-bg);
}

/* ====== Switch ====== */
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}
.switch input { opacity: 0; width: 0; height: 0; }
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 34px;
}
.slider:before {
  position: absolute; content: "";
  height: 20px; width: 20px;
  left: 3px; bottom: 3px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}
.switch input:checked + .slider {
  background-color: var(--primary-color);
}
.switch input:checked + .slider:before {
  transform: translateX(24px);
}

/* ====== Modal ====== */
.modal-content {
  background-color: var(--light-bg);
  color: var(--secondary-color);
  border: 1px solid var(--border-color);
}
.modal-header {
  border-bottom: 1px solid var(--border-color);
  color: var(--primary-color);
  font-weight: bold;
}
.btn-primary, .btn-success, .btn-warning {
  background-color: var(--primary-color);
  border: none;
  color: #fff;
}
.btn-primary:hover, .btn-success:hover, .btn-warning:hover {
  background-color: #e67e00;
}
.btn-outline-light {
  background-color: #f5f5f5;
  color: var(--secondary-color);
  border: 1px solid var(--border-color);
}
.btn-outline-light:hover {
  background-color: #eee;
}

/* ====== Roles ====== */
.role-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #fafafa;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  padding: 8px 12px;
  margin-bottom: 8px;
  color: var(--secondary-color);
}
.role-item span {
  font-weight: 500;
}

/* ====== Badges ====== */
.badge.bg-warning {
  background-color: var(--primary-color) !important;
  color: white !important;
}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Manage Admin Managers</h4>
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addManagerModal">
              <i class="fa fa-plus"></i> Add Manager
            </button>
          </div>
          <div class="card-body">
            <table id="my-table" class="table table-striped datatable">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @php $userRoleIds = json_decode($user->permissions ?? '[]', true); @endphp
                    @foreach($userRoleIds as $roleId)
                      <span class="badge bg-warning me-1">{{ ucwords(str_replace('_', ' ', $roleId)) }}</span>
                    @endforeach
                  </td>
                  <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal_{{ $user->id }}">
                      <i class="fa fa-edit text-warning me-2"></i>
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $user->id }}">
                      <i class="fa fa-trash text-danger"></i>
                    </a>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal_{{ $user->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form method="post" action="{{ route('admin.admin_manager.delete', $user->id) }}">
                            @csrf
                            <div class="modal-header">
                              <h5 class="modal-title">Delete Manager</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal_{{ $user->id }}" tabindex="-1">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <form method="post" action="{{ route('admin.admin_manager.update', $user->id) }}">
                            @csrf
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Admin Manager</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-3">
                              <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                              </div>

                              <!-- Roles -->
                              <div class="col-md-12 mt-2">
                                <label class="form-label">Select Roles</label>
                                <div class="row">
                                  @php
                                    $roles = ['manage_outstanding', 'manage_orders', 'manage_platform', 'manage_notification', 'manage_payment', 'manage_product', 'sign_up_users', 'abandoned_orders'];
                                    $selectedRoles = json_decode($user->permissions ?? '[]', true);
                                  @endphp
                                  @foreach($roles as $role)
                                  <div class="col-md-6 role-item">
                                    <span>{{ ucwords(str_replace('_', ' ', $role)) }}</span>
                                    <label class="switch">
                                      <input type="checkbox" name="user_roles[]" value="{{ $role }}" {{ in_array($role, $selectedRoles) ? 'checked' : '' }}>
                                      <span class="slider"></span>
                                    </label>
                                  </div>
                                  @endforeach
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-warning">Save Changes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Add Manager Modal -->
<div class="modal fade" id="addManagerModal" tabindex="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="{{ route('admin.admin_manager.save') }}" class="row g-3">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Admin Manager</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="number" name="phone" value="{{ old('phone') }}" class="form-control">
          </div>

          <!-- Roles -->
          <div class="col-md-12 mt-2">
            <label class="form-label">Select Roles</label>
            <div class="row">
              @foreach(['manage_outstanding', 'manage_orders', 'manage_platform', 'manage_notification', 'manage_payment', 'manage_product', 'manage_operational_state', 'sign_up_users', 'abandoned_orders'] as $role)
              <div class="col-md-6 role-item">
                <span>{{ ucwords(str_replace('_', ' ', $role)) }}</span>
                <label class="switch">
                  <input type="checkbox" name="user_roles[]" value="{{ $role }}">
                  <span class="slider"></span>
                </label>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Add Manager</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
