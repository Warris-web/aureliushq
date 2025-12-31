@extends('user_new.app')

@section('content')

<!-- Categories Section Start -->

<section>
  <div class="custom-container">
    <ul class="categories-list">
      @foreach($categories as $category)
        <li class="{{ $loop->first ? 'mt-0' : '' }}">
          <a href="{{ route('food.category', $category->category_url) }}" class="d-flex align-items-center">
            
            <div class="ps-3">
              <h2>{{ $category->name }}</h2>
              <h4 class="mt-1">Total {{ $category->foods_count }} item{{ $category->foods_count > 1 ? 's' : '' }} available</h4>
              <div class="arrow">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
              </div>
            </div>

            <div class="categories-img">
              <img class="img-fluid img"
     src="{{ $category->image ? asset($category->image) : asset('https://cdn3.editmysite.com/app/website/static/images/category-placeholder.png?width=2400&optimize=medium') }}"
     alt="{{ $category->name }}"
     style="width:100px; height:100px; object-fit:cover; border-radius:8px;" />

            </div>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</section>
<!-- Categories Section End -->

@endsection