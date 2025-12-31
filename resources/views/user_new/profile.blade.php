@extends('user_new.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary-color: #ff8c00;
        --dark-color: #1a1a1a;
        --light-bg: #f8f9fa;
        --card-shadow: 0 2px 12px rgba(255, 140, 0, 0.08);
        --hover-shadow: 0 4px 20px rgba(255, 140, 0, 0.15);
    }

    .profile-container {
        background: var(--light-bg);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .profile-header {
        margin-bottom: 2rem;
    }

    .profile-header h1 {
        color: var(--dark-color);
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
    }

    .custom-accordion {
        margin-bottom: 1.25rem;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        background: #fff;
        transition: all 0.3s ease;
    }

    .custom-accordion:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-2px);
    }

    .accordion-header-custom {
        background: linear-gradient(135deg, var(--primary-color) 0%, #ff7700 100%);
        color: #fff;
        font-weight: 600;
        font-size: 1.05rem;
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        user-select: none;
    }

    .accordion-header-custom:hover {
        background: linear-gradient(135deg, #ff7700 0%, #ff6600 100%);
    }

    .accordion-header-custom.active {
        background: linear-gradient(135deg, #ff7700 0%, var(--primary-color) 100%);
    }

    .accordion-header-custom.danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .accordion-icon {
        transition: transform 0.3s ease;
        font-size: 1.2rem;
    }

    .accordion-header-custom.active .accordion-icon {
        transform: rotate(180deg);
    }

    .accordion-content-custom {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
    }

    .accordion-content-custom.active {
        max-height: 2000px;
    }

    .accordion-body-custom {
        background: #fff;
        padding: 2rem 1.5rem;
        font-size: 0.95rem;
        color: #333;
    }

    .btn-primary, .btn-success {
        background: linear-gradient(135deg, var(--primary-color) 0%, #ff7700 100%) !important;
        border: none !important;
        color: #fff !important;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(255, 140, 0, 0.2);
    }

    .btn-primary:hover, .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 140, 0, 0.3);
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(255, 140, 0, 0.2);
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.3);
    }

    .profile-img-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #fff5e6 0%, #fff 100%);
        border-radius: 12px;
        border: 2px dashed var(--primary-color);
    }

    .profile-img-container img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid var(--primary-color);
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(255, 140, 0, 0.2);
    }

    .profile-info-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .profile-info-card p {
        margin-bottom: 0.75rem;
        padding: 0.75rem;
        background: #fff;
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
    }

    .profile-info-card strong {
        color: var(--dark-color);
        display: inline-block;
        min-width: 150px;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 38px;
        cursor: pointer;
        color: var(--primary-color);
        transition: color 0.3s ease;
    }

    .toggle-password:hover {
        color: #ff7700;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.15);
    }

    .list-group-item {
        border: none;
        border-radius: 10px;
        margin-bottom: 0.75rem;
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background: #fff5e6;
        transform: translateX(5px);
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-header.bg-warning {
        background: linear-gradient(135deg, var(--primary-color) 0%, #ff7700 100%) !important;
        color: #fff;
    }

    .modal-header.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
    }

    .modal-body {
        padding: 2rem 1.5rem;
    }

    .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem 1.5rem;
    }

    .text-danger.fw-semibold {
        font-size: 1.05rem;
        padding: 1rem;
        background: #fff5f5;
        border-radius: 10px;
        border-left: 4px solid #dc3545;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .profile-img-container {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-info-card strong {
            display: block;
            margin-bottom: 0.25rem;
        }
    }
</style>

<div class="ec-content-wrapper profile-container">
    <div class="content p-3 container">
        <div class="profile-header">
            <h1>My Profile</h1>
        </div>

        <div id="customAccordion">

            <!-- BIO DATA -->
            <div class="custom-accordion">
                <div class="accordion-header-custom active" data-target="bio">
                    <span><i class="fa fa-user me-2"></i> Bio Data</span>
                    <i class="fa fa-chevron-down accordion-icon"></i>
                </div>
                <div class="accordion-content-custom active" id="bio">
                    <div class="accordion-body-custom">
                        <div class="profile-img-container">
                            <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQuWnBi14T_ynO92D9yJX_F6IJocVAd5q3pZA&s') }}" id="profilePreview">
                            <form id="imageForm" action="{{ route('profile.uploadImage') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="profile_image" id="profileInput" accept="image/*" class="form-control mb-2" style="max-width:300px;">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-upload me-1"></i> Update Image
                                </button>
                            </form>
                        </div>

                        <div class="profile-info-card">
                            <p><strong>Full Name:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Alt Email:</strong> {{ Auth::user()->alt_email ?? 'N/A' }}</p>
                            <p><strong>Alternative Phone:</strong> {{ Auth::user()->alt_phone ?? 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'N/A' }}</p>
                            <p><strong>LGA:</strong> {{ ucfirst(Auth::user()->lga) }}</p>
                            <p><strong>State:</strong> {{ ucfirst(Auth::user()->state) }}</p>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#altEmailModal" data-bs-backdrop="static" data-bs-keyboard="false">
                                <i class="fa fa-envelope me-1"></i> Update Alternative Email
                            </button>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#altPhoneModal" data-bs-backdrop="static" data-bs-keyboard="false">
                                <i class="fa fa-phone me-1"></i> Update  Phone  Contact
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="custom-accordion">
                <div class="accordion-header-custom" data-target="address">
                    <span><i class="fa fa-map-marker me-2"></i> Address</span>
                    <i class="fa fa-chevron-down accordion-icon"></i>
                </div>
                <div class="accordion-content-custom" id="address">
                    <div class="accordion-body-custom">
                        @php
                            $addresses = json_decode(Auth::user()->home_address ?? '[]', true);
                        @endphp
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fa fa-plus-circle me-1"></i> Add Address
                            </button>
                        </div>
                        @if(!empty($addresses))
                            <ul class="list-group">
                                @foreach($addresses as $index => $address)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fa fa-home me-2" style="color: var(--primary-color);"></i>{{ $address }}</span>
                                        <form class="delete-address-form" action="{{ route('profile.deleteAddress', $index) }}" method="POST">
    @csrf
    <button type="button" class="btn btn-sm btn-danger delete-address-btn">
        <i class="fa fa-trash"></i>
    </button>
</form>

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-map-marker" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem;"></i>
                                <p class="text-muted fst-italic">No addresses added yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CHANGE PASSWORD -->
            <div class="custom-accordion">
                <div class="accordion-header-custom" data-target="password">
                    <span><i class="fa fa-lock me-2"></i> Change Password</span>
                    <i class="fa fa-chevron-down accordion-icon"></i>
                </div>
                <div class="accordion-content-custom" id="password">
                    <div class="accordion-body-custom">
                        <form action="{{ route('profile.changePassword') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3 position-relative">
                                <label class="fw-semibold mb-2">Old Password</label>
                                <input type="password" name="old_password" class="form-control" id="old_password" required>
                                <span class="toggle-password" toggle="#old_password"><i class="fa fa-eye"></i></span>
                            </div>
                            <div class="form-group mb-3 position-relative">
                                <label class="fw-semibold mb-2">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password" required>
                                <span class="toggle-password" toggle="#new_password"><i class="fa fa-eye"></i></span>
                            </div>
                            <div class="form-group mb-3 position-relative">
                                <label class="fw-semibold mb-2">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                                <span class="toggle-password" toggle="#new_password_confirmation"><i class="fa fa-eye"></i></span>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle me-1"></i> Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- DELETE ACCOUNT -->
            <div class="custom-accordion">
    <div class="accordion-header-custom danger" data-target="delete">
        <span><i class="fa fa-exclamation-triangle me-2"></i> Delete Account</span>
        <i class="fa fa-chevron-down accordion-icon"></i>
    </div>
    <div class="accordion-content-custom" id="delete">
        <div class="accordion-body-custom">
            <p class="text-danger fw-semibold">
                <i class="fa fa-warning me-2"></i> Warning: Deleting your account is permanent and cannot be undone.
            </p>

            <button 
                class="btn btn-danger @if(Auth::user()->loan_balance > 0) disabled-btn @endif"
                data-bs-toggle="modal" 
                data-bs-target="#deleteAccountModal"
                @if(Auth::user()->loan_balance > 0) disabled @endif
            >
                <i class="fa fa-trash me-1"></i> Delete My Account
            </button>

            @if(Auth::user()->loan_balance > 0)
                <small class="text-warning d-block mt-2">
                    You cannot delete your account while you have an outstanding.
                </small>
            @endif
        </div>
    </div>
</div>

<style>
.disabled-btn {
    opacity: 0.6;
    cursor: not-allowed !important;
    pointer-events: none; /* ensures it can’t be clicked */
}
</style>

        </div>
    </div>

    {{-- All Modals --}}

    {{-- Alternative Email Modal --}}
    <div class="modal fade" id="altEmailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="emailForm">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="fa fa-envelope me-2"></i> Update Alternative Email</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-semibold mb-2">Email Address</label>
                            <input type="email" id="alt_email" class="form-control" placeholder="Enter email address" required>
                        </div>
                        <div id="otpSection" class="mb-3 d-none">
                            <label class="fw-semibold mb-2">OTP Code</label>
                            <input type="text" id="otpInput" class="form-control" placeholder="Enter OTP">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="sendOtpBtn">
                            <i class="fa fa-paper-plane me-1"></i> Send OTP
                        </button>
                        <button type="button" class="btn btn-success d-none" id="verifyOtpBtn">
                            <i class="fa fa-check me-1"></i> Verify & Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Phone Modal --}}
    <div class="modal fade" id="altPhoneModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="phoneForm">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="fa fa-phone me-2"></i> Update  Phone</h5>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-semibold mb-2">Phone Number</label>
                            <input type="text" id="phone" class="form-control" value="{{ Auth::user()->phone }}" placeholder="Enter phone number" required>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-semibold mb-2">Alt Phone Number</label>
                            <input type="text" id="alt_phone" class="form-control" value="{{ Auth::user()->alt_phone }}" placeholder="Enter Alt phone number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="verifyPhoneOtpBtn">
                            <i class="fa fa-check me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Address Modal --}}
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.addAddress') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="fa fa-map-marker me-2"></i> Add Address</h5>
                    </div>
                    <div class="modal-body">
                        <label class="fw-semibold mb-2">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter new address" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save me-1"></i> Save Address
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.deleteAccount') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i> Confirm Account Deletion</h5>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Enter your password to confirm deletion:</p>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash me-1"></i> Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Custom Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const accordionHeaders = document.querySelectorAll('.accordion-header-custom');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const isActive = this.classList.contains('active');
            
            if (isActive) {
                // Close this accordion
                this.classList.remove('active');
                content.classList.remove('active');
            } else {
                // Open this accordion
                this.classList.add('active');
                content.classList.add('active');
            }
        });
    });
});

// Password toggle functionality
document.querySelectorAll('.toggle-password').forEach(el => {
    el.addEventListener('click', function() {
        const input = document.querySelector(this.getAttribute('toggle'));
        input.type = input.type === 'password' ? 'text' : 'password';
        this.innerHTML = input.type === 'password'
            ? '<i class="fa fa-eye"></i>'
            : '<i class="fa fa-eye-slash"></i>';
    });
});

// OTP Email functionality
document.getElementById('sendOtpBtn').addEventListener('click', function () {
    let email = document.getElementById('alt_email').value;
    if (!email) return alert('Enter an email');
    fetch('{{ route('profile.sendOtp') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
        body: JSON.stringify({ email })
    }).then(r=>r.json()).then(d=>{
        if(d.status==='ok'){
            alert('OTP sent!');
            document.getElementById('otpSection').classList.remove('d-none');
            this.classList.add('d-none');
            document.getElementById('verifyOtpBtn').classList.remove('d-none');
        } else alert(d.message);
    });
});

document.getElementById('verifyOtpBtn').addEventListener('click', function () {
    let otp = document.getElementById('otpInput').value;
    let email = document.getElementById('alt_email').value;
    fetch('{{ route('profile.verifyOtp') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
        body: JSON.stringify({ email, otp })
    }).then(r=>r.json()).then(d=>{
        alert(d.message);
        if(d.status==='ok') location.reload();
    });
});

document.getElementById('verifyPhoneOtpBtn').addEventListener('click', function () {
    let phone_alt = document.getElementById('alt_phone').value;
    let phone = document.getElementById('phone').value;
    fetch('{{ route('profile.updateAltPhone') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
        body: JSON.stringify({ phone, phone_alt })
    }).then(r=>r.json()).then(d=>{
        alert(d.message);
        if(d.status==='ok') location.reload();
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll('.delete-address-btn').forEach(function(button) {

        button.addEventListener('click', function (e) {
            let form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this address?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });

    });

});
</script>


@endsection