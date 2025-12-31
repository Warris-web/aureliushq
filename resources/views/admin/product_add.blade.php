@extends('admin.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">➕ Add Food Item</h3>
        <a href="{{ route('foods.all') }}" class="btn btn-outline-warning rounded-pill px-3">
            <i class="fas fa-list me-1"></i> View All
        </a>
    </div>

   
    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form class="row g-4" method="POST" action="{{ route('foods.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Image Upload -->
                <div class="col-lg-4 text-center">
                    <div class="mb-3">
                        <div class="position-relative d-inline-block">
                            <img id="previewImage" 
                                 src="{{ asset('https://community.softr.io/uploads/db9110/original/2X/7/74e6e7e382d0ff5d7773ca9a87e6f6f8817a68a6.jpeg') }}" 
                                 alt="preview" 
                                 class="rounded shadow-sm img-fluid border" 
                                 style="max-height: 220px; object-fit: cover;">

                            <label for="imageUpload" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-2 rounded-circle shadow">
                                <i class="fas fa-edit"></i>
                            </label>
                            <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" class="d-none" />
                        </div>
                        <p class="text-muted small mt-2">Upload food image (JPG/PNG)</p>
                    </div>
                </div>

                <!-- Food Details -->
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="e.g. Grilled Chicken">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select Category</label>
                            <select name="category" class="form-select">
                                <option value="">-- Choose Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Short Description</label>
                            <textarea  id='myTextarea2' class="form-control" name="short_description" rows="2" placeholder="Brief intro">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Amount (₦)</label>
                            <input type="number" step="0.01" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Enter price">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Full Description</label>
                            <textarea id='myTextarea' class="form-control" name="full_description" rows="4" placeholder="Detailed description of the food">{{ old('full_description') }}</textarea>
                        </div>

                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-success px-4 rounded-pill">
                                <i class="fas fa-save me-1"></i> Save Food
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    document.getElementById('imageUpload').addEventListener('change', function (event) {
        let reader = new FileReader();
        reader.onload = function () {
            document.getElementById('previewImage').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection
