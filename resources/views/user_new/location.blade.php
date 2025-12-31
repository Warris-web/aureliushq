@extends('user_new.app')

@section('content')
<div  style="margin-top:-35px !important;" class="container my-4">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-semibold" style="color: #ff7b00;">All Locations</h4>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark btn-sm">
        ← Go Back
    </a>
</div>

    @if(count($addresses) > 0)
        <div class="address-list">
            @foreach($addresses as $index => $address)
                <div class="address-card" style="animation-delay: {{ $index * 0.1 }}s;">
                    <p class="full-address">{{ $address->full_address }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No addresses saved yet.</p>
    @endif
</div>

<style>
/* Container styling */
.address-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Card styling */
.address-card {
    background: #1c1c1c; /* deep dark background */
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(255,123,0,0.15);
    border-left: 5px solid #ff7b00; /* dark orange */
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideIn 0.5s forwards;
    transition: all 0.3s ease-in-out;
}

/* Card Text */
.full-address {
    font-size: 16px;
    margin: 0;
    font-weight: 500;
    color: #ffffff; /* White text for contrast */
}

/* Animation */
@keyframes fadeSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effect */
.address-card:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 6px 15px rgba(255,123,0,0.25);
}
</style>
@endsection
