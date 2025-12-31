@extends('user.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Support Tickets</h1>
                
            </div>
            <div>
                <!-- Button trigger modal -->
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTicketModal">
                    <i class="fa fa-plus-circle me-1"></i> Add Ticket
                </button>
            </div>
        </div>

        <div class="row p-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">All Tickets</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(isset($tickets) && count($tickets) > 0)
                                <table class="table table-striped table-hover" id="my-table">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>User</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $index => $ticket)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                                                <td>{{ $ticket->subject }}</td>
                                                <td>{{ Str::limit($ticket->message, 40) }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($ticket->status == 'pending') bg-warning
                                                        @elseif($ticket->status == 'resolved') bg-success
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ ucfirst($ticket->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($ticket->status === 'pending')
                                                        <!-- Edit Button -->
                                                        <button class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editTicketModal_{{ $ticket->id }}"
                                                                title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>

                                                        <!-- Delete Button -->
                                                        <a href="#"
                                                           class="btn btn-sm btn-outline-danger"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#deleteTicket_{{ $ticket->id }}"
                                                           title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Locked</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Edit Ticket Modal -->
                                            <div class="modal fade" id="editTicketModal_{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('support.update', $ticket->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Ticket</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Subject</label>
                                                                    <input type="text" name="subject" class="form-control"
                                                                           value="{{ old('subject', $ticket->subject) }}" required>
                                                                </div>
                                                                <div class="form-group mt-2">
                                                                    <label>Message</label>
                                                                    <textarea name="message" class="form-control" rows="4" required>{{ old('message', $ticket->message) }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fa fa-edit me-1"></i> Update Ticket
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Ticket Modal -->
                                            <div class="modal fade" id="deleteTicket_{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('support.delete', $ticket->id) }}" method="post">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-danger">Delete Ticket</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this Ticket?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted text-center">No support tickets found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('support.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   name="subject"
                                   placeholder="Enter ticket subject"
                                   required>
                            @error('subject')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Message</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                      rows="4" placeholder="Describe your issue..." required></textarea>
                            @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus-circle me-1"></i> Add Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
