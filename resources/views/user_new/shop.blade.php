@extends('user_new.app')

@section('content')
<!-- banner section start -->
  <style>
  #dashboard_food_display{
      background: #fff7f4; /* light orange */
      padding:20px;

}
</style>


    
    <!-- Breadcrumb / Title Section -->
<section class="section-t-space">
    <div class="custom-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li  class="breadcrumb-item"><a style="color:black; font-size:20px; font-weight:700;" href="{{ route('user.packages') }}">Shop </a></li>
            </ol>
        </nav>
    </div>
</section>



 <?php
$ambassadors = $settings->shop_images ?? null;

if (is_null($ambassadors)) {
    $ambassadors = [];
} else {
    $ambassadors = json_decode($ambassadors, true) ?? [];
    $ambassadors = array_filter($ambassadors); // Removes all null values
}
 
?>

<style>
/* Ambassador Section */
.ambassador-section {
  max-width: 90%;
  margin: 15px auto;
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  text-align: center;
}

/* Image as banner */
.ambassador-banner {
  width: 100%;
  height: 120px; /* adjust as needed */
  object-fit: cover;
  display: block;
}

/* Indicators (dots) */
.carousel-indicators {
  position: static;  /* remove absolute positioning */
  margin-top: 8px;   /* space between image and dots */
}
.carousel-indicators [data-bs-target] {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: rgba(0,0,0,0.4);
}
.carousel-indicators .active {
  background-color: #ff6600; /* active dot color */
}
</style>

<!-- Ambassador Slider -->
<div class="ambassador-section">
  <div id="ambassadorCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

    <!-- Slides -->
    <div class="carousel-inner">
      <?php foreach ($ambassadors as $index => $amb): ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
          <img src="<?= asset($amb)?>" class="ambassador-banner" alt="Ambassador">
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Dots (Indicators below) -->
    <div class="carousel-indicators">
      <?php foreach ($ambassadors as $index => $amb): ?>
        <button type="button" data-bs-target="#ambassadorCarousel" data-bs-slide-to="<?= $index ?>" 
          class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index+1 ?>"></button>
      <?php endforeach; ?>
    </div>
  </div>
</div>


    <!-- Foods Section Start -->
<section style="margin-top:-30px"  class="section-t-space">
    <div id="dashboard_food_display" class="custom-container">
        


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