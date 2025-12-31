@extends('user_new.app')

@section('content')
<style>
    :root {
        --primary-color: #ff8c00; /* Orange */
        --secondary-color: #000000; /* Black */
    }

    .card-header {
        background-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .btn-success, .btn-outline-primary, .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .btn-outline-primary {
        background-color: transparent !important;
        color: var(--primary-color) !important;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .badge.bg-warning {
        background-color: #ffa500 !important;
        color: #000 !important;
    }

    /* Table styling */
    table th {
        background: var(--secondary-color);
        color: #fff;
    }

    /* Responsive table for mobile */
    @media (max-width: 768px) {
        table thead {
            display: none;
        }
        table, table tbody, table tr, table td {
            display: block;
            width: 100%;
        }
        table tr {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #fff;
        }
        table td {
            text-align: right;
            position: relative;
            padding-left: 50%;
        }
        table td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            width: 45%;
            text-align: left;
            font-weight: bold;
            color: var(--secondary-color);
        }
        .btn {
            font-size: 12px;
            padding: 5px 8px;
        }
    }

    .modal-header {
        background-color: var(--primary-color);
        color: #fff;
    }
</style>

<div class="ec-content-wrapper">
    <div class="content">
        <div style="padding:20px;" class="breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h1 class="mb-0">Support Tickets</h1>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTicketModal">
                <i class="fa fa-plus-circle me-1"></i> Add Ticket
            </button>
        </div>

        <div class="row p-3">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">All Tickets</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(isset($tickets) && count($tickets) > 0)
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Response</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $index => $ticket)
                                            <tr>
                                                <td data-label="S/N">{{ $index + 1 }}</td>
                                                <td data-label="Subject">{{ $ticket->subject }}</td>
                                                <td data-label="Message">{{ Str::limit($ticket->message, 40) }}</td>
                                                <td data-label="Status">
                                                    <span class="badge 
                                                        @if($ticket->status == 'pending') bg-warning
                                                        @elseif($ticket->status == 'resolved') bg-success
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ ucfirst($ticket->status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Response">
                                                    @if(is_null($ticket->response))
                                                                                                            <span class="text-info">Awaiting Feedback</span>

                                                    @else
                                                                                                            <span class="text-success">{{ $ticket->response }}</span>

                                                    @endif
                                                </td>
                                                <td data-label="Action" class="text-center">
                                                    @if($ticket->status === 'pending')
                                                        <button class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editTicketModal_{{ $ticket->id }}"
                                                                title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteTicket_{{ $ticket->id }}"
                                                                title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <span class="text-muted">Locked</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editTicketModal_{{ $ticket->id }}" tabindex="-1">
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
                                                                <button type="submit" class="btn btn-success">Update Ticket</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteTicket_{{ $ticket->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('support.delete', $ticket->id) }}" method="post">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title">Delete Ticket</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this ticket?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    <div class="modal fade" id="addTicketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('support.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Enter ticket subject" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Describe your issue..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
