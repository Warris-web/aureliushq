@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        
        <div class="row p-3">
            <!-- Categories Table -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0 me-2">Food Categories &nbsp;&nbsp;   <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fa fa-plus-circle me-1"></i> Add Category
                </button></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(isset($categories) && count($categories) > 0)
                                <table class="table table-striped table-hover" id="my-table">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $index => $category)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>@if($category->image)
            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="60" height="60" style="object-fit:cover;border-radius:8px;">
        @else
            <span class="text-muted">No image</span>
        @endif</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal_{{ $category->id }}"
                                                        title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <a href="#"
                                                   class="btn btn-sm btn-outline-danger"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#category_{{ $category->id }}"
                                                   title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Category Modal -->
                                        <div class="modal fade" id="editCategoryModal_{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit  Category</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="categoryName_{{ $category->id }}">Category Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                       value="{{ old('name', $category->name) }}" required>
                                                            </div>

                                                            <div class="form-group mt-3">
    <label for="categoryImage_{{ $category->id }}">Category Image (optional)</label>
    <input type="file" class="form-control" id="categoryImage_{{ $category->id }}" name="image" accept="image/*">

    @if($category->image)
        <div class="mt-2">
            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="80" height="80" style="object-fit:cover;border-radius:8px;">
        </div>
    @endif
</div>

                                                        </div>
                                                        

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fa fa-edit me-1"></i> Update Category
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="category_{{$category->id}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('category.delete', $category->id) }}" method="post">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-danger">Category Delete</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this Category?
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
                                <p class="text-muted text-center">No categories added yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('category.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Add  Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="categoryName"
                                   name="name"
                                   placeholder="e.g. Cereals"
                                   required>
                            @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
    <label for="categoryImage">Category Image (optional)</label>
    <input type="file" class="form-control" id="categoryImage" name="image" accept="image/*">
</div>

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus-circle me-1"></i> Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
