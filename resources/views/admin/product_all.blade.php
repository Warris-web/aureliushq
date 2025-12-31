@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1">All Products</h2>
            </div>
            <a href="{{ route('admin.product.add') }}" class="btn btn-dark">
                <i class="fas fa-plus me-1"></i> Add Product
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-3">
            <input  type="text" id="searchInput" class="form-control" placeholder="Search products by name, category, or amount...">
        </div>

        <!-- Products Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productsTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Date Added</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($foods as $food)
                                <tr>
                                    <td>
                                        @if($food->image)
                                            <img src="{{ asset($food->image) }}" alt="{{ $food->name }}" class="rounded" style="width:50px; height:50px; object-fit:cover;">
                                        @else
                                            <img src="{{ asset('https://community.softr.io/uploads/db9110/original/2X/7/74e6e7e382d0ff5d7773ca9a87e6f6f8817a68a6.jpeg') }}" alt="No Image" class="rounded" style="width:50px; height:50px; object-fit:cover;">
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $food->name }}</td>
                                    <td>
                                        @if($food->cat)
                                            <span class="badge bg-info text-dark">{{ $food->cat->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">Uncategorized</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-success">₦{{ number_format($food->amount, 2) }}</td>
                                    <td>{{ $food->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('foods.edit', $food->id) }}">
                                                        <i class="fas fa-edit me-2 text-primary"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $food->id }}">
                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $food->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete <strong>{{ $food->name }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash-alt me-1"></i> Yes, Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Real-Time Search Script -->
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#productsTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    });
</script>
@endsection
