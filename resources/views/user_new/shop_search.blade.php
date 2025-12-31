@extends('user_new.app')

@section('content')
<!-- banner section start -->
  
    
    <!-- Breadcrumb / Title Section -->
<section class="section-t-space">
    <div class="custom-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item ">@if($query)
    You searched for: <strong>{{ $query }}</strong>
@endif
</span></li>
            </ol>
        </nav>
    </div>
</section>

    <!-- Foods Section Start -->
<section class="section-t-space">
    <div class="custom-container">
        <div class="title d-flex justify-content-between align-items-center">
            {{-- <h2 class="text-center">Shop</h2> --}}
        </div>

        <div class="row g-4">
            @if(count($foods) > 0)
                @foreach($foods as $food)
                    <div class="col-6">
                        <div class="product-box">
                            <div class="product-box-img">
                                                                <h5 class="badge bg-warning">{{ optional($food->cat)->name ?? 'Uncategorized' }}</h5>

                                <a href="{{ route('shop.detail', $food->slug) }}">
                                    <img class="img" 
                                         src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                                         alt="{{ $food->name }}" />
                                </a>

                                {{-- <div class="cart-box">
                                    <a href="javascript:void(0)" 
                                       onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})" 
                                       class="cart-bag">
                                        <i class="iconsax bag" data-icon="basket-2"></i>
                                    </a>
                                </div> --}}
                            </div>

                            {{-- Like / Favorite button --}}
                            {{-- <div class="like-btn animate inactive">
                                <img class="outline-icon" src="{{ asset('assets/images/svg/like.svg') }}" alt="like" />
                                <img class="fill-icon" src="{{ asset('assets/images/svg/like-fill.svg') }}" alt="like" />
                                <div class="effect-group">
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                </div>
                            </div> --}}

                            <div class="product-box-detail">
                                <h4>{{ $food->name }}</h4>
                                <div class="d-flex justify-content-between gap-3">
                                    <h3 class="fw-semibold">₦{{ number_format($food->amount, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
                    <div class="text-center p-5 border rounded-4 shadow-sm bg-light" style="max-width: 500px;">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-4x text-muted"></i>
                        </div>
                        <h4 class="fw-bold text-secondary">No Products Available</h4>
                        <p class="text-muted">Please check back later for amazing updates 🌟</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>



<!-- Foods Section End -->
 <!-- other furniture section end -->

    <!-- banner section start -->
    {{-- <section class="banner-wapper grid-banner">
      <div class="custom-container">
        <div class="row">
          <div class="col-6">
            <div class="banner-bg">
              <img class="img-fluid img-bg" src="assets/images/banner/banner-3.jpg" alt="banner-3" />
              <div class="banner-content">
                <h3>Wingback Chair</h3>
              </div>
              <a href="shop.html" class="more-btn d-block">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                <h3>View More</h3>
              </a>
              <div class="banner-bg"></div>
            </div>
          </div>

          <div class="col-6">
            <div class="banner-bg">
              <img class="img-fluid img-bg" src="assets/images/banner/banner-4.jpg" alt="banner-3" />
              <div class="banner-content">
                <h3>Wingback Chair</h3>
              </div>
              <a href="shop.html" class="more-btn d-block">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                <h3>View More</h3>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section> --}}
    <!-- banner section end -->

@endsection