@extends('auth.app')

@section('content')
<style>
    .signup-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
        flex-wrap: wrap;
    }
    .signup-image {
        flex: 1;
        background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBT3kvoSawunVAxcSG_6vFcNUcGx9Sm138vQ&s') no-repeat center center;
        background-size: cover;
    }
    .signup-form-section {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
        background: #fff;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    }
    .signup-card {
        width: 100%;
        max-width: 450px;
    }
    .signup-card h4 {
        margin-bottom: 20px;
        color: #333;
    }
    .signup-card .form-control {
        border-radius: 8px;
        padding: 10px;
    }
    .signup-card button {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-size: 16px;
    }
    .signup-card .text-blue {
        color: #007bff;
        text-decoration: none;
    }
    .signup-card .text-blue:hover {
        text-decoration: underline;
    }
    .brand-logo {
        text-align: center;
        margin-bottom: 20px;
    }
    .brand-logo img {
        max-width: 180px;
    }

    /* ✅ Hide image on small screens */
    @media (max-width: 768px) {
        .signup-image {
            display: none;
        }
        .signup-form-section {
            flex: 1 1 100%;
            box-shadow: none;
        }
    }
</style>

<div class="signup-container">
    <!-- Left Image -->
    <div class="signup-image"></div>

    <!-- Right Signup Form -->
    <div class="signup-form-section">
        <div class="signup-card">
            <div class="brand-logo">
                <a href="#">
                    <img src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="Logo">
                </a>
            </div>

            <h4>Sign Up</h4>

            <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="row">

        <div class="form-group col-md-6 mb-3">
            <label for="first_name" class="fw-bold">First Name 
            </label>
            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Match BVN Name" value="{{ old('first_name') }}">
            @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group col-md-6 mb-3">
            <label for="last_name" class="fw-bold">Last Name 
            </label>
            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Match BVN Name" value="{{ old('last_name') }}">
            @error('last_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group col-md-12 mb-3">
            <label for="email" class="fw-bold">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group col-md-12 mb-3">
            <label for="phone" class="fw-bold">Phone Number 
            </label>
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Number linked to your BVN" value="{{ old('phone') }}">
            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group col-md-12 mb-3">
            <label for="state" class="fw-bold">State</label>
            <select name="state" id="state" class="form-control">
                <option value="">Loading States...</option>
            </select>
            @error('state')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group col-md-12 mb-3">
            <label for="lga" class="fw-bold">Local Government Area (LGA)</label>
            <select name="lga" id="lga" class="form-control">
                <option value="">Select State First</option>
            </select>
            @error('lga')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div style="display:none;" class="form-group col-md-12 mb-3">
            <input type="text" name="country" class="form-control" value="Nigeria" readonly>
        </div>

        <div class="form-group col-md-12 mb-3">
    <label for="employee_status" class="fw-bold">Employee Status</label>
    <select id="employee_status" name="employee_status" class="form-control" required>
        <option value="">Select Status</option>
        <option value="Employed">Employed</option>
        <option value="Non Student/Non Employed">Non Student / Non Employed</option>
        <option value="Trader">Trader</option>
        <option value="Student">Student</option>
    </select>
    @error('employee_status')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<!-- Student fields (hidden by default) -->
<div id="student_fields" style="display:none;">
    <div class="form-group col-md-12 mb-3">
        <label for="student_id" class="fw-bold">Student ID</label>
        <input type="file" id="student_id" name="student_id" class="form-control" placeholder="Enter Student ID">
        @error('student_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="form-group col-md-12 mb-3">
        <label for="school_name" class="fw-bold">School Name</label>
        <input type="text" id="school_name" name="school_name" class="form-control" placeholder="Enter School Name">
        @error('school_name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const employeeStatus = document.getElementById("employee_status");
    const studentFields = document.getElementById("student_fields");
    const studentIdInput = document.getElementById("student_id");
    const schoolNameInput = document.getElementById("school_name");

    function toggleStudentFields() {
        if (employeeStatus.value === "Student") {
            studentFields.style.display = "block";
            studentIdInput.setAttribute("required", "required");
            schoolNameInput.setAttribute("required", "required");
        } else {
            studentFields.style.display = "none";
            studentIdInput.removeAttribute("required");
            schoolNameInput.removeAttribute("required");
            studentIdInput.value = "";
            schoolNameInput.value = "";
        }
    }

    employeeStatus.addEventListener("change", toggleStudentFields);

    // Initial check if form is pre-filled
    toggleStudentFields();
});

</script>


        <div class="form-group col-md-12 mb-3">
            <label for="password" class="fw-bold">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group col-md-12 mb-3">
            <label for="password_confirmation" class="fw-bold">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re-enter Password">
        </div>

        <div class="col-md-12 mb-3">
            <label>
                <input type="checkbox" name="terms"> I Agree to the Terms
            </label>
            @error('terms')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary mb-3">
                <i class="fa fa-user-plus"></i> Sign Up
            </button>
            <p>Already have an account?
                <a class="text-blue" href="{{ route('login') }}">Sign In</a>
            </p>
        </div>

    </div>
</form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    let stateDropdown = $("#state");
    let lgaDropdown = $("#lga");

    // ✅ Load states from Laravel endpoint
    $.get("{{ url('/locations/states') }}", function(states) {
        stateDropdown.empty().append('<option value="">Select State</option>');
        states.forEach(function(state){
            stateDropdown.append('<option value="'+ state.id +'">'+ state.name +'</option>');
        });
    });

    // ✅ Load LGAs dynamically
    stateDropdown.on("change", function(){
        let selectedState = $(this).val();
        if(selectedState){
            lgaDropdown.empty().append('<option>Loading LGAs...</option>');
            $.get("{{ url('/locations/lgas') }}/" + encodeURIComponent(selectedState), function(data){
                lgaDropdown.empty().append('<option value="">Select LGA</option>');
                if(data.lgas){
                    data.lgas.forEach(function(lga){
                        lgaDropdown.append('<option value="'+ lga +'">'+ lga +'</option>');
                    });
                }
            });
        } else {
            lgaDropdown.empty().append('<option value="">Select State First</option>');
        }
    });
});
</script>
@endsection
