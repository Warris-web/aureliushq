@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <div class="row p-3">
            <div class="col-md-12">
                <div class="card shadow border-0">
                    <div class="card-header d-flex justify-content-between align-items-center header-gradient">
                        <h5 class="card-title text-white mb-0">
                            <i class="fa fa-map-marker-alt me-2"></i> Operational States
                        </h5>
                        <button class="btn btn-light text-dark fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#addStateModal">
                            <i class="fa fa-plus-circle me-1"></i> Add State
                        </button>
                    </div>

                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-middle table-hover table-borderless">
                                <thead class="table-dark text-center align-middle">
                                    <tr>
                                        <th style="width: 10%">S/N</th>
                                        <th style="width: 50%">State Name</th>
                                        <th style="width: 40%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($states as $index => $state)
                                        <tr>
                                            <td class="fw-semibold text-center">{{ $index + 1 }}</td>
                                            <td class="fw-semibold">{{ $state->state_name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('state.orders.preparing', $state->state_name) }}" 
                                                    class="btn btn-sm action-btn me-1">
                                                    <i class="fa fa-eye me-1"></i> Preparing
                                                </a>
                                                <a href="{{ route('state.orders.ready', $state->state_name) }}" 
                                                    class="btn btn-sm action-btn me-1">
                                                    <i class="fa fa-truck me-1"></i> Dispatched
                                                </a>
                                                <button class="btn btn-sm edit-btn me-1" data-bs-toggle="modal" data-bs-target="#editStateModal_{{ $state->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $state->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">No states added yet.</td>
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

    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('operational.states.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header header-gradient text-white">
                    <h5 class="modal-title"><i class="fa fa-plus-circle me-2"></i> Add Operational State</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="fw-semibold mb-2">Select State</label>
                    <select name="state_id" class="form-control border-dark" onchange="document.getElementById('state_name').value = this.options[this.selectedIndex].text" required>
                        <option value="">-- Choose a State --</option>
                        @foreach($allStates as $st) 
                            <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="state_name" name="state_name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-darkorange text-white"><i class="fa fa-check me-1"></i> Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit & Delete Modals -->
    @foreach($states as $state)
    <div class="modal fade" id="editStateModal_{{ $state->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('operational.states.update', $state->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-black text-white">
                    <h5 class="modal-title"><i class="fa fa-edit me-2"></i> Edit State</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="fw-semibold mb-2">Select State</label>
                    <select name="state_id" class="form-control border-dark"
                            onchange="this.form.state_name.value=this.options[this.selectedIndex].text" required>
                        <option value="">-- Choose a State --</option>
                        @foreach($allStates as $st) 
                            <option value="{{ $st['id'] }}" {{ $state->state_id == $st['id'] ? 'selected' : '' }}>
                                {{ $st['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="state_name" value="{{ $state->state_name }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-darkorange text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal_{{ $state->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('operational.states.delete', $state->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i> Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>{{ $state->state_name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

<style>
    :root {
        --darkorange: #ff8c00;
        --black: #000;
    }

    .header-gradient {
        background: linear-gradient(135deg, var(--black), var(--darkorange));
        border-bottom: 3px solid var(--darkorange);
    }

    .btn-darkorange {
        background-color: var(--darkorange);
        border: none;
        transition: 0.3s;
    }

    .btn-darkorange:hover {
        background-color: #e67e00;
    }

    .action-btn {
        border: 1px solid var(--darkorange);
        color: var(--darkorange);
        background: transparent;
        transition: 0.3s;
    }

    .action-btn:hover {
        background: var(--darkorange);
        color: #fff;
    }

    .edit-btn {
        border: 1px solid #000;
        color: #000;
        transition: 0.3s;
    }

    .edit-btn:hover {
        background: #000;
        color: #fff;
    }

    .delete-btn {
        border: 1px solid #dc3545;
        color: #dc3545;
        transition: 0.3s;
    }

    .delete-btn:hover {
        background: #dc3545;
        color: #fff;
    }

    .table thead {
        background-color: var(--black);
        color: #fff;
    }

    .modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--darkorange);
    }
</style>
@endsection
