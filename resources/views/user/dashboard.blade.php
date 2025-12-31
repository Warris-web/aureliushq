

@extends('user.app')
@section('content')



			<!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
					<!-- Top Statistics -->

    <style>


        .dash-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .card-body {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
        }

        .card-body h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-body p {
            font-size: 0.95rem;
            margin-bottom: 0;
            opacity: 0.9;
        }

        .card-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 2rem;
            opacity: 0.3;
        }

        .account-section {
            position: relative;
        }

        .account-number {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .copy-btn {
            position: absolute;
            top: 10px;
            right: 50px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            border-radius: 6px;
            padding: 5px 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }

        .copy-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05);
        }

        .copy-btn.copied {
            background: rgba(76, 175, 80, 0.8);
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

		.card-body h2{
			color:#fff !important;
		}
        .custom-toast {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 8px;
        }

        @media (max-width: 576px) {
            .card-body h2 {
                font-size: 1.4rem;
            }
            .card-icon {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
    <div class="col-xl-3 col-sm-6 p-3 d-flex">
        <div class="card card-mini dash-card card-1 w-100">
            <div class="card-body">
                <i class="fas fa-wallet card-icon"></i>
                <h2 class="mb-1">₦{{ number_format(Auth::user()->wallet_balance) }}</h2>
                <p>Wallet Balance</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 p-3 d-flex">
        <div class="card card-mini dash-card card-2 w-100">
            <div class="card-body">
                <i class="fas fa-chart-line card-icon"></i>
                <h2 class="mb-1">₦{{ number_format(Auth::user()->loan_balance) }}</h2>
                <p>Loan Balance</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 p-3 d-flex">
        <div class="card card-mini dash-card card-3 w-100">
            <div class="card-body account-section text-center">
                @if(empty(Auth::user()->virtual_account_number))
                    <!-- Generate button -->
                    <button style="background:black;" class="btn btn-primary w-100" id="generateBtn" onclick="generateAccount()">
                        Generate Account
    <i id="spinner" class="fa fa-spinner fa-spin d-none"></i>
                    </button>
                @else
                    @php
                        $accountData = json_decode(Auth::user()->virtual_account_number, true);
                    @endphp

                    <!-- Account Number + Copy -->
                    <div class="d-flex justify-content-center align-items-center mb-2">
                        <h2 class="mb-0 account-number me-2" id="accountNumber">
                            {{ $accountData['account_number'] ?? '' }}
                        </h2>
                        <button class="btn btn-sm btn-outline-secondary" onclick="copyAccountNumber()" id="copyBtn">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>

                    <!-- Bank Name -->
                    <p class="text-muted mb-0">
                        {{ $accountData['bank']['name'] ?? '' }} | {{ $accountData['account_name'] ?? '' }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 p-3 d-flex">
        <div class="card card-mini dash-card card-4 w-100">
            <div class="card-body">
                <i class="fas fa-user-circle card-icon"></i>
                <h2 class="mb-1">Active</h2>
                <p>User Account</p>
            </div>
        </div>
    </div>
</div>

    </div>

    <!-- Toast Container -->
    <div class="toast-container">
        <div id="copyToast" class="toast custom-toast" role="alert">
            <div class="toast-body d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                Account number copied to clipboard!
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyAccountNumber() {
            const accountNumber = document.getElementById('accountNumber').textContent;
            const copyBtn = document.getElementById('copyBtn');
            const toast = new bootstrap.Toast(document.getElementById('copyToast'));

            // Copy to clipboard
            navigator.clipboard.writeText(accountNumber).then(function() {
                // Change button appearance
                copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                copyBtn.classList.add('copied');

                // Show toast
                toast.show();

                // Reset button after 2 seconds
                setTimeout(() => {
                    copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copy';
                    copyBtn.classList.remove('copied');
                }, 2000);

            }).catch(function(err) {
                console.error('Could not copy text: ', err);

                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = accountNumber;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    document.execCommand('copy');
                    copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    copyBtn.classList.add('copied');
                    toast.show();

                    setTimeout(() => {
                        copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copy';
                        copyBtn.classList.remove('copied');
                    }, 2000);
                } catch (err) {
                    console.error('Fallback copy failed: ', err);
                }

                document.body.removeChild(textArea);
            });
        }
    </script>

    <script>
function generateAccount() {
    let btn = document.getElementById("generateBtn");
    let spinner = document.getElementById("spinner");

    // save the original text
    let originalText = btn.innerText.trim();

    btn.disabled = true;
    btn.firstChild.textContent = "Generating... "; // change button text
    spinner.classList.remove("d-none");

    fetch("{{ route('generate_virtual_account') }}", {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === true) {
            alert("Account generated successfully!");
            location.reload();
        } else {
            alert("Failed to generate account: " + (data.message || "Unknown error"));
        }
    })
    .catch(err => {
        alert("Error: " + err.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.firstChild.textContent = originalText + " "; // restore original text
        spinner.classList.add("d-none");
    });
}


</script>

</body>
</html>



					<div class="row">
    <div class="col-12 p-b-15">
        <!-- Recent Order Table -->
        <div class="card card-table-border-none card-default recent-orders" id="recent-orders">
            <div class="card-header justify-content-between">
                <h2>Recent Food Orders</h2>
                <div class="">
                    <span><a href="{{ route('user.orders') }}">View All Orders</a></span>
                </div>
            </div>
            <div class="card-body pt-0 pb-5">
                <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Food Item</th>
                            <th class="d-none d-lg-table-cell">Quantity</th>
                            <th class="d-none d-lg-table-cell">Order Date</th>
                            <th class="d-none d-lg-table-cell">Order Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($recent_orders as $order)
        <tr>
            <!-- Order Number -->
            <td>{{ $order->order_number }}</td>

            <!-- Food Items (decode JSON) -->
            <td>
                @php
                    $items = $order->items;
                @endphp
                @if(is_array($items))
                    @foreach($items as $item)
                        <span class="d-block">{{ $item['name'] ?? 'Item' }} (x{{ $item['qty'] ?? 1 }})</span>
                    @endforeach
                @else
                    <span>-</span>
                @endif
            </td>

            <!-- Quantity (sum all items) -->
            <td class="d-none d-lg-table-cell">
                @if(is_array($items))
                    {{ collect($items)->sum('qty') }}
                @else
                    -
                @endif
            </td>

            <!-- Order Date -->
            <td class="d-none d-lg-table-cell">{{ $order->created_at->format('M d, Y') }}</td>

            <!-- Total Amount -->
            <td class="d-none d-lg-table-cell">₦{{ number_format($order->total_amount, 2) }}</td>

            <!-- Status -->
            <td>
                @php
                    $statusClass = [
                        'completed' => 'success',
                        'pending'   => 'warning',
                        'cancelled' => 'danger',
                        'confirmed' => 'primary',
                    ][$order->status] ?? 'secondary';
                @endphp
                <span class="badge badge-{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </td>

            <!-- Actions -->
            <td class="text-right">
    <a href="{{ route('user.orders.show', $order->order_number) }}"
       class="btn btn-sm btn-primary">
        <i class="fas fa-eye"></i> View
    </a>
</td>

        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No recent orders</td>
        </tr>
    @endforelse
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>

					<div class="row">
{{--
						<div class="col-xl-7">
							<!-- Top Products -->
							<div class="card card-default ec-card-top-prod">
								<div class="card-header justify-content-between">
									<h2>Top Products</h2>
									<div>
										<button class="text-black-50 mr-2 font-size-20"><i
												class="mdi mdi-cached"></i></button>
										<div class="dropdown show d-inline-block widget-dropdown">
											<a class="dropdown-toggle icon-burger-mini" href="#" role="button"
												id="dropdown-product" data-bs-toggle="dropdown" aria-haspopup="true"
												aria-expanded="false" data-display="static">
											</a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><a href="#">Update Data</a></li>
												<li class="dropdown-item"><a href="#">Detailed Log</a></li>
												<li class="dropdown-item"><a href="#">Statistics</a></li>
												<li class="dropdown-item"><a href="#">Clear Data</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card-body mt-10px mb-10px py-0">
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p1.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Baby cotton shoes</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">58</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$520</span>
												<del>$580</del>
											</p>
										</div>
									</div>
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p2.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Hoodies for men</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">20</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$250</span>
												<del>$300</del>
											</p>
										</div>
									</div>
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p3.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Long slive t-shirt</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">10</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$480</span>
												<del>$654</del>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div> --}}
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

<?php
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$has_done_kyc = has_done_kyc(Auth::user()->id);
$kycLevels = kyc_levels();
?>

{{-- 🔹 If user has NOT paid onboarding, show onboarding modal --}}
@if(!$has_paid_onboarding)

<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.btn:hover {
    transform: scale(1.05);
}
</style><button type="button" class="btn btn-warning d-none" id="showOnboardingModal" data-bs-toggle="modal" data-bs-target="#onboardingModal"></button>

   {{-- ✅ Fancy Onboarding Modal (Uncancelable + Two Payment Options) --}}
<div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg"
             style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff7e00,#ff5500,#ff9900); background-size:300% 300%; animation:gradientFlow 8s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white">🚀 Complete Your Onboarding</h3>
                <p class="mb-0 text-white" style="opacity:0.85;">Make a one-time payment to unlock full access</p>
            </div>

            <!-- Body -->
            <div class="modal-body d-flex flex-column justify-content-center align-items-center text-center px-5 py-4"
                 style="background:#fffaf5;">

               <!-- Payment Info -->
<p class="fw-bold mb-3" style="color:#ff5500; font-size:1.3rem;">
    Pay only ₦1000 for account activation.
    <br>Complete your KYC later to fully unlock all features.
</p>

<!-- Features -->
<ul class="list-unstyled mb-4 text-start" style="max-width:400px; font-size:1rem; color:#444;">
    <li class="mb-2">✅ Full access to all basic platform features after activation</li>
    <li class="mb-2">✅ Option to complete KYC for advanced benefits</li>
</ul>

                <!-- ✅ Two Payment Options -->
                <!-- ✅ Two Payment Options (Always Side by Side) -->
<div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
    <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}"
       class="btn btn-lg fw-bold text-white shadow-sm"
       style="background:linear-gradient(135deg,#00b9f1,#007ad9); border:none; border-radius:50px; padding:12px 40px; font-size:1.1rem; min-width:180px;">
         Pay with Paystack
    </a>
    <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}"
       class="btn btn-lg fw-bold text-white shadow-sm"
       style="background:linear-gradient(135deg,#ff7e00,#ff5500); border:none; border-radius:50px; padding:12px 40px; font-size:1.1rem; min-width:180px;">
        Pay with Fincra
    </a>
</div>

            </div>
        </div>
    </div>
</div>

<!-- 🌈 Gradient Animation -->

    {{-- ✅ Auto-show onboarding modal --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('showOnboardingModal').click();
        });
    </script>






{{-- 🔹 If user paid onboarding but has NOT done KYC, show KYC modal --}}
@elseif(!$has_done_kyc)
    <!-- Hidden Trigger Button -->
<button type="button" class="btn btn-warning d-none" id="showKycModal" data-bs-toggle="modal" data-bs-target="#kycModal"></button>

{{-- ✅ Fancy KYC Modal (Uncancelable) --}}
<div class="modal fade" id="kycModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff7e00,#ff5500,#ff9900); background-size:300% 300%; animation:gradientFlow 8s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white"> Choose Account Type</h3>
                <p class="mb-0 text-white" style="opacity:0.85;">Select the verification level you wish to complete</p>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-5" style="background:#fffaf5;">

                <p class="fw-bold text-center mb-4" style="color:#ff5500; font-size:1.1rem;">
                    Select an Account level below to see its details and start verification.
                </p>

                <!-- Fancy KYC Level Cards -->
                <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                    @foreach($kycLevels as $key => $level)
                        <div class="kyc-level-card shadow-sm" data-level="{{ $key }}"
                             style="width:200px; padding:15px; border-radius:15px; background:#fff; cursor:pointer; transition:all 0.3s; border:1px solid #eee; text-align:center;">
                            <h5 class="fw-bold mb-2" style="color:#ff5500;">{{ $level['title'] }}</h5>
                            <p class="text-muted small mb-0">Click to view details</p>
                        </div>
                    @endforeach
                </div>

                <hr>

                <!-- KYC Details Section -->
                <div id="kyc-details" style="display:none;">
                    <h4 id="kyc-title" class="fw-bold mb-2" style="color:#ff5500;"></h4>
                    <p id="kyc-desc" class="text-muted mb-4"></p>

                    <form id="kyc-form" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg fw-bold text-white shadow-sm"
                                style="background:linear-gradient(135deg,#ff7e00,#ff5500); border:none; border-radius:50px; padding:5px 40px; font-size:1rem; transition:0.3s;">
                             Proceed
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🌈 Animation + Hover Effects -->
<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.kyc-level-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(255, 85, 0, 0.15);
    border-color: #ff7e00;
}
.active-card {
    border: 2px solid #ff7e00 !important;
    box-shadow: 0 6px 20px rgba(255, 85, 0, 0.15) !important;
    transform: translateY(-3px);
}
</style>

    {{-- ✅ Auto-show KYC modal & dynamic behavior --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('showKycModal').click();

    const kycData = @json($kycLevels);
    const title = document.getElementById('kyc-title');
    const desc = document.getElementById('kyc-desc');
    const form = document.getElementById('kyc-form');
    const details = document.getElementById('kyc-details');

    document.querySelectorAll('.kyc-level-card').forEach(card => {
        card.addEventListener('click', () => {
            const data = kycData[card.dataset.level];
            title.textContent = data.title;
            desc.innerHTML = data.description;
            form.action = data.endpoint || "#";
            details.style.display = 'block';
            document.querySelectorAll('.kyc-level-card').forEach(c => c.classList.remove('active-card'));
            card.classList.add('active-card');
        });
    });
});
</script>

@endif

{{-- ✅ Custom Styles --}}
<style>
    .kyc-level-btn {
        background:linear-gradient(135deg,#ff7e00,#ff5500);
        color:white; font-weight:bold; border:none;
        border-radius:25px; padding:12px 20px; width:45%;
        box-shadow:0 4px 10px rgba(255,85,0,0.3);
        transition:transform .2s, box-shadow .3s;
    }
    .kyc-level-btn:hover {
        transform:scale(1.05);
        box-shadow:0 6px 15px rgba(255,85,0,0.5);
    }
</style>


@if(!$has_paid_onboarding)
<!-- Hidden trigger button -->
<button type="button" class="btn btn-warning d-none" id="showOnboardingModal" data-bs-toggle="modal" data-bs-target="#onboardingModal"></button>

<!-- ✅ Elegant Onboarding Modal -->
<div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- 🌈 Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff8c00,#ff6a00); background-size:300% 300%; animation:gradientFlow 6s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white">🚀 Complete Your Onboarding</h3>
                <p class="mb-0 text-white-50" style="font-size:0.95rem;">Make a one-time payment to unlock full access</p>
            </div>

            <!-- 💰 Modal Body -->
            <div class="modal-body text-center px-4 py-4" style="background:#fffaf5;">
                <p class="fw-bold mb-3" style="color:#ff8c00; font-size:1.1rem;">
                    Pay only ₦1000 for account activation.
                    <br><span style="font-size:0.9rem; color:#555;">Complete your KYC later to unlock all features.</span>
                </p>

                <!-- 🌟 Features -->
                <ul class="list-unstyled mb-4 text-start mx-auto" style="max-width:400px; font-size:0.9rem; color:#333;">
                    <li class="mb-2">✅ Get instant access to all basic features</li>
                    <li class="mb-2">✅ Upgrade later with KYC for premium benefits</li>
                </ul>

                <!-- Payment Buttons -->
<div class="payment-buttons d-flex justify-content-center">
    <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}" class="paystack-btn">
         Pay with Paystack
    </a>
    <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}" class="fincra-btn">
        Pay with Fincra
    </a>
</div>

<style>
.payment-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px; /* space between buttons */
}

.payment-buttons a {
    flex: 0 0 200px; /* fixed width, side by side */
    text-align: center;
    padding: 10px 20px;
    border-radius: 40px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* Paystack */
.paystack-btn {
    background: linear-gradient(135deg,#ff8c00,#e67e00);
    color: #fff;
    box-shadow: 0 4px 10px rgba(255,140,0,0.3);
}
.paystack-btn:hover {
    background: linear-gradient(135deg,#ffa733,#ff8c00);
    box-shadow: 0 6px 14px rgba(255,140,0,0.45);
}

/* Fincra */
.fincra-btn {
    background: #fff;
    color: #222;
    border: 2px solid #ff8c00;
}
.fincra-btn:hover {
    background: #fff5eb;
}

/* Mobile: stack buttons */
@media (max-width: 576px) {
    .payment-buttons {
        flex-wrap: wrap; /* allow wrapping on small screens */
    }


    .payment-buttons a {
    flex: 0 0 110px; /* fixed width, side by side */
    text-align: center;
    padding: 10px 40px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

}
</style>

                <!-- ⬅️ Back Button -->
                <div class="mt-4">
                    <a href="javascript:void(0)" class="text-dark fw-semibold"
                       style="text-decoration:none; font-size:0.9rem; opacity:0.8;" id="dismissModalBtn">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🌈 Gradient Animation + Custom Button Styles -->
<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

/* Payment button container */
.payment-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

/* Base button styles */
.payment-buttons a {
    display: inline-block;
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    padding: 10px 20px;
    border-radius: 40px;
    text-decoration: none;
    transition: all 0.3s ease;
    width: 48%;
}

/* Paystack button (orange gradient) */
.paystack-btn {
    background: linear-gradient(135deg, #ff8c00, #e67e00);
    color: #fff;
    box-shadow: 0 4px 10px rgba(255,140,0,0.3);
}
.paystack-btn:hover {
    background: linear-gradient(135deg, #ffa733, #ff8c00);
    box-shadow: 0 6px 14px rgba(255,140,0,0.45);
}

/* Fincra button (white with orange border) */
.fincra-btn {
    background: #fff;
    color: #222;
    border: 2px solid #ff8c00;
}
.fincra-btn:hover {
    background: #fff5eb;
}

/* Responsive: stack on mobile */
@media (max-width: 576px) {
    .payment-buttons a {
        width: 10%;
        font-size: 0.9rem;
        padding: 9px 16px;
    }
}
</style>

<!-- 🚀 Auto-show & Proper Dismiss -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const modalTrigger = document.getElementById('showOnboardingModal');
    modalTrigger.click();

    const dismissBtn = document.getElementById('dismissModalBtn');
    dismissBtn.addEventListener('click', () => {
        const modalEl = document.getElementById('onboardingModal');
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
        // remove backdrop properly
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });
});
</script>

@endif

@endsection
