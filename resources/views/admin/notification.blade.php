@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <div class="row p-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Notifications</h5>
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                            <i class="fa fa-plus-circle me-1"></i> Add Notification
                        </button>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notifications as $index => $notification)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $notification->title }}</td>
                                            <td>{{ Str::limit($notification->body, 40) }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNotificationModal_{{ $notification->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteNotificationModal_{{ $notification->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No notifications yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addNotificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('notification.add') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Add Notification</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="fw-semibold">Title</label>
                    <input type="text" name="title" class="form-control mb-3" required>

                    <label class="fw-semibold">Body</label>
                    <textarea name="body" class="form-control" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle me-1"></i> Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit & Delete Modals -->
    @foreach($notifications as $notification)
        <!-- Edit Modal -->
        <div class="modal fade" id="editNotificationModal_{{ $notification->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('notification.update', $notification->id) }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">Edit Notification</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control mb-3" value="{{ $notification->title }}" required>

                        <label class="fw-semibold">Body</label>
                        <textarea name="body" class="form-control" rows="4" required>{{ $notification->body }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteNotificationModal_{{ $notification->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('notification.delete', $notification->id) }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this notification?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

<style>
.modal-content {
    background-color: #fff !important;
    border-radius: 10px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.3);
}
</style>
@endsection
