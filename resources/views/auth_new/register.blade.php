@extends('auth_new.app')

@section('content')




<div class="auth-img">
    <img class="img-fluid auth-bg"
        src="https://www.agrohandlers.com/uploaded_files/blog-pix/202309180828_ORGANIC-FOOD-STORE-BUSINESS-PLAN-IN-NIGERIA.jpg"
        alt="auth_bg" />
    <div class="auth-content">
        <div>
            <h2>Create Account</h2>
            <h4 class="p-0">Join us today, it only takes a minute!</h4>
        </div>
    </div>
</div>

<form class="auth-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
    <div class="custom-container">

        {{-- First Name --}}
        <div class="form-group">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" name="first_name"
                class="form-control @error('first_name') is-invalid @enderror"
                placeholder="Enter First Name" value="{{ old('first_name') }}" required>
            @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Last Name --}}
        <div class="form-group">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" name="last_name"
                class="form-control @error('last_name') is-invalid @enderror"
                placeholder="Enter Last Name" value="{{ old('last_name') }}" required>
            @error('last_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter Email" value="{{ old('email') }}" required>
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Phone --}}
        <div class="form-group">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" id="phone" name="phone"
                class="form-control @error('phone') is-invalid @enderror"
                placeholder="Enter Phone Number" value="{{ old('phone') }}" required>
            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- State --}}
        <div class="form-group">
            <label for="state" class="form-label">State</label>
            <select name="state" id="state" class="form-control @error('state') is-invalid @enderror" required>
                <option value="">Loading States...</option>
            </select>
            @error('state')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- LGA --}}
        <div class="form-group">
            <label for="lga" class="form-label">Local Government Area (LGA)</label>
            <select name="lga" id="lga" class="form-control @error('lga') is-invalid @enderror" required>
                <option value="">Select State First</option>
            </select>
            @error('lga')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <input type="hidden" name="country" value="Nigeria">

        {{-- Employee Status --}}
        <div class="form-group">
            <label for="employee_status" class="form-label">Employee Status</label>
            <select id="employee_status" name="employee_status"
                class="form-control @error('employee_status') is-invalid @enderror" required>
                <option value="">Select Status</option>
                <option value="Employed">Employed</option>
                <option value="Non Student/Non Employed">Non Student / Non Employed</option>
                <option value="Trader">Trader</option>
                <option value="Student">Student</option>
            </select>
            @error('employee_status')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Student Fields --}}
        <div id="student_fields" style="display:none;">
            <div class="form-group">
                <label for="student_id" class="form-label">Student ID Card</label>
                <input type="file" id="student_id" name="student_id"
                    class="form-control @error('student_id') is-invalid @enderror">
                @error('student_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="school_name" class="form-label">School Name</label>
                <input type="text" id="school_name" name="school_name"
                    class="form-control @error('school_name') is-invalid @enderror"
                    placeholder="Enter School Name">
                @error('school_name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>

<div class="form-group">
    <label for="referral_code" class="form-label">Referral Code (optional)</label>
    <input type="text" id="referral_code" name="referral_code"
        class="form-control @error('referral_code') is-invalid @enderror"
        placeholder="Enter referral code if any" value="{{ request('ref') ?? old('referral_code') }}">
    @error('referral_code')<small class="text-danger">{{ $message }}</small>@enderror
</div>

        {{-- Password --}}
        <div class="form-group position-relative">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password')"
                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;">
                👁
            </button>
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group position-relative">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control" placeholder="Re-enter Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')"
                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;">
                👁
            </button>
        </div>

        {{-- Proceed Button --}}
        <div class="submit-btn mt-3">
            <button type="button" class="btn auth-btn w-100" id="proceedBtn">
                <i class="fa fa-arrow-right"></i> Proceed
            </button>
        </div>

        <h4 class="signup mt-3">
            Already have an account?
            <a style="color:black; font-weight:bold;" href="{{ route('login') }}">Sign In</a>
        </h4>
    </div>
</form>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms of Use</h5>
      </div>

      <div class="modal-body terms-content" style="max-height: 400px; overflow-y: auto; line-height: 1.6;">
        {!! $settings->login_terms ?? "Not Set" !!}
      </div>

      <div class="modal-footer d-flex justify-content-between terms-footer" style="display: none; opacity: 0; transition: opacity 0.3s ease;">
        <button  type="button" class="btn btn-dark" data-bs-dismiss="modal">Decline</button>
        <button style="background:darkorange; color:white;" type="button" class="btn btn-warning" id="acceptTermsBtn">Accept</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('termsModal');

    modal.addEventListener('shown.bs.modal', function() {
        const termsBody = modal.querySelector('.terms-content');
        const footer = modal.querySelector('.terms-footer');

        // Always hide the buttons first when modal opens
        footer.style.display = 'none';
        footer.style.opacity = '0';

        if (termsBody && footer) {
            // When user scrolls
            termsBody.addEventListener('scroll', function onScroll() {
                const scrollPosition = termsBody.scrollTop + termsBody.clientHeight;
                const scrollHeight = termsBody.scrollHeight;

                // If user reaches bottom of scrollable area
                if (scrollPosition >= scrollHeight - 5) {
                    footer.style.display = 'flex';
                    setTimeout(() => footer.style.opacity = '1', 50);
                } else {
                    // Hide again if user scrolls back up
                    footer.style.opacity = '0';
                    setTimeout(() => footer.style.display = 'none', 300);
                }
            });
        }
    });
});
</script>

{{-- Scripts --}}
<script>
function togglePassword(fieldId) {
    let field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}

document.addEventListener("DOMContentLoaded", function () {
    const employeeStatus = document.getElementById("employee_status");
    const studentFields = document.getElementById("student_fields");
    const studentIdInput = document.getElementById("student_id");
    const schoolNameInput = document.getElementById("school_name");

    function toggleStudentFields() {
        if (employeeStatus.value === "Student") {
            studentFields.style.display = "block";
            studentIdInput.required = true;
            schoolNameInput.required = true;
        } else {
            studentFields.style.display = "none";
            studentIdInput.required = false;
            schoolNameInput.required = false;
            studentIdInput.value = "";
            schoolNameInput.value = "";
        }
    }

    employeeStatus.addEventListener("change", toggleStudentFields);
    toggleStudentFields();

    // Load states
    fetch("{{ url('/locations/states') }}")
        .then(res => res.json())
        .then(states => {
            let stateDropdown = document.getElementById("state");
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            states.forEach(state => {
                stateDropdown.innerHTML += `<option value="${state.id}">${state.name}</option>`;
            });
        });

    // Load LGAs
    document.getElementById("state").addEventListener("change", function() {
        let selectedState = this.value;
        let lgaDropdown = document.getElementById("lga");
        if (selectedState) {
            lgaDropdown.innerHTML = '<option>Loading LGAs...</option>';
            fetch("{{ url('/locations/lgas') }}/" + encodeURIComponent(selectedState))
                .then(res => res.json())
                .then(data => {
                    lgaDropdown.innerHTML = '<option value="">Select LGA</option>';
                    if (data.lgas) {
                        data.lgas.forEach(lga => {
                            lgaDropdown.innerHTML += `<option value="${lga}">${lga}</option>`;
                        });
                    }
                });
        } else {
            lgaDropdown.innerHTML = '<option value="">Select State First</option>';
        }
    });

    // Proceed Button → Open Terms Modal
    document.getElementById("proceedBtn").addEventListener("click", function() {
        let termsModal = new bootstrap.Modal(document.getElementById("termsModal"));
        termsModal.show();
    });

    
});


</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".auth-form");
    const proceedBtn = document.getElementById("proceedBtn");
    const acceptBtn = document.getElementById("acceptTermsBtn");

    acceptBtn.addEventListener("click", async function () {
        const modalEl = document.getElementById("termsModal");
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        modalInstance.hide();

        // Clear previous validation messages
        document.querySelectorAll(".text-danger").forEach(el => el.innerHTML = "");

        // Disable the Proceed button and show spinner
        proceedBtn.disabled = true;
        proceedBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value,
                },
                body: formData
            });

            const data = await response.json();

            // Re-enable the Proceed button
            proceedBtn.disabled = false;
            proceedBtn.innerHTML = '<i class="fa fa-arrow-right"></i> Proceed';

            if (response.status === 422) {
                // Validation errors
                Object.keys(data.errors).forEach(field => {
                    let input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        let errorTag = input.parentElement.querySelector(".text-danger");
                        if (!errorTag) {
                            errorTag = document.createElement("small");
                            errorTag.classList.add("text-danger");
                            input.parentElement.appendChild(errorTag);
                        }
                        errorTag.innerHTML = data.errors[field][0];
                    }
                });
            } else if (data.status === "success") {
                showSessionModal('success', data.message + ' Redirecting in 5sec')
setTimeout(() => {
        window.location.href = data.redirect;
    }, 5000);            } else {
            showSessionModal('error', data.message || "An unexpected error occurred.");

            }

        } catch (error) {
            console.error(error);
                        showSessionModal('error', error.message || "Network error, please try again.");


            // Restore button if network fails
            proceedBtn.disabled = false;
            proceedBtn.innerHTML = '<i class="fa fa-arrow-right"></i> Proceed';
        }
    });
});
</script>


@endsection
