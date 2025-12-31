@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            
        </div>

        <div class="row p-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">All KYC Levels</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            @if($levels->count() > 0)
                                <table class="table table-striped table-hover" id="kyc-table">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Title</th>
                                            <th>Credit Limit</th>
                                            <th>Credit Amount</th>
                                            <th>Repayment Period</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($levels as $index => $level)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $level->title }}</td>
                                                <td>{{ $level->credit_limit ?? 'N/A' }}</td>
                                                <td>{{ number_format($level->credit_amount_limit) }}</td>
                                                <td>{{ $level->repayment_period ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-outline-dark"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editKycModal_{{ $level->key }}"
                                                            title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editKycModal_{{ $level->key }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <form action="{{ route('admin.kyc.update', $level->key) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit KYC Level: {{ ucfirst($level->key) }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group mb-2 mt-2">
                                                                    <label>Title</label>
                                                                    <input type="text" name="title" class="form-control"
                                                                           value="{{ old('title', $level->title) }}" required>
                                                                </div>
                                                                <textarea id="myTextareaBox" name="description" class="form-control" rows="4" required>
    {{ old('description', $level->description) }}
</textarea>
                                                               

                                                                <div class="form-group mt-2 mb-2">
                                                                    <label>Terms & Conditions</label>
                                                                     <textarea id="myTextareaBox" name="term_condition" class="form-control" rows="4" required>
    {{ old('term_condition', $level->term_condition) }}
</textarea>
                                                                </div>
                                                                <div class="form-group mt-2 mb-2">
                                                                    <label>Repayment Period</label>
                                                                    <input type="text" name="repayment_period" class="form-control"
                                                                           value="{{ old('repayment_period', $level->repayment_period) }}">
                                                                </div>
                                                                <div class="form-group mt-2 mb-2">
                                                                    <label>Credit Limit</label>
                                                                    <input type="text" name="credit_limit" class="form-control"
                                                                           value="{{ old('credit_limit', $level->credit_limit) }}">
                                                                </div>
                                                                <div class="form-group mt-2 mb-2">
                                                                    <label>Credit Amount Limit</label>
                                                                    <input type="number" name="credit_amount_limit" class="form-control"
                                                                           value="{{ old('credit_amount_limit', $level->credit_amount_limit) }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fa fa-save me-1"></i> Update
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted text-center">No KYC levels found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
