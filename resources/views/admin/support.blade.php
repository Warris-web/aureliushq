@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        
        <div class="row p-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">All Tickets</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            @if(isset($tickets) && count($tickets) > 0)
                                <table class="table table-striped table-hover" id="my-table">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>User</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Response</th>
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
                                                <td>{{ ($ticket->message) }}</td>
<td>
    @empty($ticket->response)
        Provide response
    @else
        {{ $ticket->response }}
    @endempty
</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($ticket->status == 'pending') bg-warning
                                                        @elseif($ticket->status == 'resolved') bg-success
                                                        @elseif($ticket->status == 'closed') bg-danger
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ ucfirst($ticket->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <!-- Update Status Button -->
                                                    <button class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#statusTicketModal_{{ $ticket->id }}"
                                                            title="Update Status">
                                                        <i class="fa fa-check"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <a href="#"
                                                       class="btn btn-sm btn-outline-danger"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteTicket_{{ $ticket->id }}"
                                                       title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                           <!-- Update Status Modal -->
<div class="modal fade" id="statusTicketModal_{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('support.updateStatus', $ticket->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Ticket Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Select Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Response</label>
                        <textarea name="response" class="form-control" rows="4" placeholder="Write your response here...">{{ $ticket->response }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Update Status
                    </button>
                </div>
            </div>
        </form>
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
</div>
@endsection
