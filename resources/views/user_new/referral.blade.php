@extends('user_new.app')

@section('content')
<style>
:root {
    --primary: #ff8c00;
    --primary-dark: #e67e00;
    --primary-light: #ffa826;
    --gradient: linear-gradient(135deg, #ff8c00 0%, #ff6b35 100%);
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
}

.container {
    margin-top: 0;
    background: white;
    border-radius: 20px;
    padding: 40px;
    max-width: 1200px;
}

/* Mobile Back Button */
.mobile-header {
    display: none;
    margin-bottom: 15px;
}
.mobile-header .back-btn {
    display: inline-block;
    background: var(--gradient);
    color: white;
    padding: 8px 16px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    box-shadow: var(--shadow-sm);
}

/* Header */
.page-header {
    text-align: center;
    margin-bottom: 35px;
}
.page-header h2 {
    font-size: 2rem;
    font-weight: 700;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.page-header p { color: #666; font-size: 0.95rem; }

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}
.stat-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 18px;
    border-radius: 10px;
    box-shadow: var(--shadow-sm);
    text-align: center;
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}
.stat-value {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--primary);
}
.stat-label {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
    margin-top: 5px;
}

/* Referral Card */
.referral-card {
    background: linear-gradient(135deg, #fff5e6 0%, #ffe8cc 100%);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    border: 2px solid #ffdd99;
}
.referral-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #8b5a00;
    margin-bottom: 10px;
    text-transform: uppercase;
}
.referral-box {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.referral-box input {
    flex: 1;
    padding: 14px 18px;
    border: none;
    outline: none;
    font-size: 15px;
    font-family: 'Courier New', monospace;
}
.referral-box button {
    background: var(--gradient);
    color: white;
    border: none;
    padding: 14px 25px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

/* Share Buttons */
.share-buttons.always-visible {
    display: flex !important;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}
.share-buttons.always-visible a {
    background: var(--gradient);
    color: white;
    padding: 10px 16px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}
.share-buttons.always-visible a:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}
.copy-btn {
    background: var(--primary-dark);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 1rem;
    margin-top: 15px;
    width: 100%;
    max-width: 240px;
    box-shadow: var(--shadow-md);
    cursor: pointer;
    transition: all 0.3s ease;
}
.copy-btn:hover {
    background: var(--primary);
    transform: translateY(-2px);
}

/* Tabs */
.tabs {
    display: flex;
    gap: 2px;
    background: #f8f9fa;
    padding: 6px;
    border-radius: 12px;
    margin-bottom: 28px;
    overflow-x: auto;
}
.tab {
    flex: 1;
    text-align: center;
    padding: 12px 20px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.95rem;
    color: #666;
    border-radius: 8px;
    transition: all 0.3s ease;
    white-space: nowrap;
    min-width: fit-content;
}
.tab:hover {
    background: rgba(255, 140, 0, 0.1);
}
.tab.active {
    color: white;
    background: var(--gradient);
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}

/* Table */
.table-responsive {
    overflow-x: auto;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
}
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}
th, td {
    padding: 14px 16px;
    text-align: left;
}
th {
    background: #f8f9fa;
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 700;
    color: #495057;
}
tbody tr {
    border-bottom: 1px solid #f1f1f1;
}
tbody tr:hover {
    background: #f9f9f9;
}
tbody tr:last-child {
    border-bottom: none;
}
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}
.status.completed { background: #d4edda; color: #155724; }
.status.pending { background: #fff3cd; color: #856404; }

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: white;
    padding: 30px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    text-align: center;
}
.modal-content h3 {
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
}
.modal-content button {
    background: var(--gradient);
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    margin-top: 15px;
    cursor: pointer;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px;
        border-radius: 0;
    }

    .mobile-header {
        display: block;
        text-align: left;
    }

    .page-header h2 {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .stat-card {
        padding: 15px 10px;
    }

    .stat-value {
        font-size: 1.2rem;
    }

    .stat-label {
        font-size: 0.7rem;
    }

    .referral-card {
        padding: 18px;
    }

    .referral-box {
        flex-direction: column;
        align-items: stretch;
    }

    .referral-box input {
        border-radius: 10px 10px 0 0;
        font-size: 13px;
        padding: 12px 15px;
    }

    .referral-box button {
        border-radius: 0 0 10px 10px;
        width: 100%;
    }

    .share-buttons.always-visible {
        gap: 8px;
    }

    .share-buttons.always-visible a {
        flex: 1 1 calc(50% - 4px);
        justify-content: center;
        padding: 10px 8px;
        font-size: 0.8rem;
    }

    .copy-btn {
        width: 100%;
        font-size: 0.9rem;
        max-width: 100%;
    }

    .tabs {
        gap: 6px;
        padding: 4px;
    }

    .tab {
        padding: 10px 12px;
        font-size: 0.85rem;
    }

    table {
        min-width: 500px;
        font-size: 0.9rem;
    }

    th, td {
        padding: 10px 12px;
    }
}

@media (max-width: 480px) {
    .page-header h2 {
        font-size: 1.3rem;
    }

    .stat-value {
        font-size: 1.1rem;
    }

    .stat-label {
        font-size: 0.65rem;
    }


}

/* Fix tab layout on small screens so all 3 show without scroll */
@media (max-width: 768px) {
    .tabs {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: nowrap;
        gap: 5px;
        overflow-x: hidden; /* remove scroll */
    }

    .tab {
        flex: 1 1 0;
        text-align: center;
        white-space: normal; /* allow wrapping if needed */
        font-size: 0.85rem;
        padding: 10px 6px;
        border-radius: 8px;
    }
}

/* Even smaller screens (e.g., 480px and below) */
@media (max-width: 480px) {
    .tabs {
        flex-wrap: wrap; /* wrap into two rows if needed */
        row-gap: 6px;
    }

    .tab {
        flex: 1 1 30%;
        padding: 10px;
        font-size: 0.8rem;
    }
}

</style>



@if($res_info && $res_info->display_referral_note === 'yes')
<div id="onboardingModal" class="custom-modal show" role="dialog" aria-modal="true">
  <div class="custom-modal-backdrop"></div>

  <div class="custom-modal-dialog" role="document">
    <div class="custom-modal-content">
      <div class="custom-modal-body">
        {!! $res_info->referral_note !!}

        <div class="btn-grid">
          <a href="{{ route('dashboard') }}" class="btn btn-cancel" id="cancelBtn">Cancel</a>
          <button type="button" class="btn btn-proceed" id="proceedBtn">Proceed</button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Base modal styles */
.custom-modal {
  position: fixed;
  inset: 0;
  display: grid;
  place-items: center;
  z-index: 2000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  margin-top: -250px;
}

/* Show modal */
.custom-modal.show {
  opacity: 1;
  visibility: visible;
}

/* Backdrop */
.custom-modal-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.6);
}

/* Dialog */
.custom-modal-dialog {
  position: relative;
  z-index: 2;
  max-width: 600px;
  width: 90%;
}

/* Content */
.custom-modal-content {
  background: #fff;
  border-radius: 12px;
  padding: 30px 24px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  text-align: center;
}

/* Body text */
.custom-modal-body {
  font-size: 16px;
  color: #222;
  line-height: 1.6;
}

/* Button grid */
.btn-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-top: 24px;
  width: 100%;
}

/* Buttons */
.btn-grid .btn {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 44px;
  font-weight: bold;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  text-decoration: none;
  transition: transform 0.2s;
}

.btn-cancel {
  background: #6c757d;
}

.btn-proceed {
  background: linear-gradient(180deg, darkorange, orangered);
}

.btn-grid .btn:hover {
  transform: translateY(-2px);
}

@media (max-width: 480px) {
  .btn-grid {
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('onboardingModal');
  const proceedBtn = document.getElementById('proceedBtn');
  const cancelBtn = document.getElementById('cancelBtn');

  // Function to hide modal with fade
  function hideModal() {
    modal.classList.remove('show');
    setTimeout(() => {
      modal.style.display = 'none';
    }, 300); // wait for fade-out
  }

  // Only close on Cancel or Proceed
  proceedBtn.addEventListener('click', hideModal);
  cancelBtn.addEventListener('click', hideModal);

  // Optional: Close on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') hideModal();
  });
});
</script>
@endif



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container">
    <div class="mobile-header">
        <a href="{{ route('dashboard') }}" class="back-btn">← Back</a>
    </div>

    <div class="page-header">
        <h2>Invite & Earn</h2>
        <p>Share your referral link and earn rewards when friends sign up and complete actions.</p>
        <button onclick="openHowItWorks()" style="background: var(--gradient); color:#fff; border:none; padding:10px 20px; border-radius:8px; margin-top:10px; cursor:pointer; font-weight:600;">How It Works</button>


<!-- Terms of Use Button -->
<button onclick="termOfUse()"
    style="background: var(--primary-dark); color:#fff; border:none; padding:10px 20px; border-radius:8px; margin-top:10px; cursor:pointer; font-weight:600;">
    Terms of Use
</button>

<!-- Terms Modal -->
<div id="terms-modal" class="terms-modal">
  <div class="terms-modal-content">
    <div class="terms-modal-header">
      <h3>Terms of Use</h3>
    </div>
    <div class="terms-modal-body">
      {!!  $res_info->term_of_use !!}
    </div>
    <div class="terms-modal-footer">
      <button class="terms-cancel-btn" onclick="closeTermsModal()">Close</button>
    </div>
  </div>
</div>

<style>
/* ===== Terms Modal Styling ===== */
.terms-modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: flex-start;
  padding-top: 50px; /* Position close to top */
}

.terms-modal-content {
  background: #fff;
  border-radius: 10px;
  width: 90%;
  max-width: 600px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
  animation: terms-fadeIn 0.3s ease;
}

.terms-modal-header {
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}

.terms-modal-header h3 {
  margin: 0;
  color: var(--primary-dark);
  font-weight: 700;
  text-align: center;
}

.terms-modal-body {
  margin-top: 15px;
  max-height: 50vh;
  overflow-y: auto;
  color: #333;
  line-height: 1.6;
}

.terms-modal-footer {
  text-align: right;
  margin-top: 15px;
}

.terms-cancel-btn {
  background: darkorange;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  display:block;
  width:100%;
  transition: background 0.2s ease;
}

.terms-cancel-btn:hover {
  background: #bbb;
}

@keyframes terms-fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}


/* Replace your existing mobile tab responsive code with this: */

/* Fix tab layout on small screens so all 3 show without scroll */
@media (max-width: 768px) {
    .tabs {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: nowrap;
        gap: 5px;
        overflow-x: hidden; /* remove scroll */
    }

    .tab {
        flex: 1 1 0;
        text-align: center;
        white-space: normal; /* allow wrapping if needed */
        font-size: 0.85rem;
        padding: 10px 6px;
        border-radius: 8px;
    }
}

/* Even smaller screens (e.g., 480px and below) */
@media (max-width: 480px) {
    .tabs {
        flex-wrap: wrap; /* wrap into two rows if needed */
        row-gap: 6px;
    }

    .tab {
        flex: 1 1 30%;
        padding: 10px;
        font-size: 0.8rem;
    }


}


</style>



<script>
function termOfUse() {
  document.getElementById('terms-modal').style.display = 'flex';
}

function closeTermsModal() {
  document.getElementById('terms-modal').style.display = 'none';
}

window.onclick = function(event) {
  const modal = document.getElementById('terms-modal');
  if (event.target === modal) {
    modal.style.display = 'none';
  }
};
</script>
    </div>

    @php
        $totalEarnings = $history->sum('amount');
    @endphp

    <div class="stats-grid">
        <div class="stat-card"><div class="stat-value">{{ $totalInvites }}</div><div class="stat-label">Total Invites</div></div>
        <div class="stat-card"><div class="stat-value">{{ $completedInvites }}</div><div class="stat-label">Completed</div></div>
        <div class="stat-card"><div class="stat-value">{{ $pendingInvites }}</div><div class="stat-label">Pending</div></div>
        <div class="stat-card"><div class="stat-value">₦{{ number_format($totalEarnings, 2) }}</div><div class="stat-label">Total Earnings</div></div>
    </div>

    <div class="referral-card">
        <div class="referral-label">Your Referral Link</div>
        <div class="referral-box">
            <input type="text" id="referralLink" value="{{ $referralLink }}" readonly>
        </div>

       <div class="share-buttons always-visible">
    <!-- WhatsApp -->
    <a href="https://wa.me/?text={{ urlencode(' Join me on Aurelius — the trusted foodstuffs instalment platform that lets you shop with ease and pay flexibly.

Sign up through my link to start enjoying stress-free food shopping, instant rewards, and a chance to unlock something special.

 ' . $referralLink) }}" target="_blank">
        <i class="fab fa-whatsapp"></i> WhatsApp
    </a>

    <!-- Facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($referralLink) }}&quote={{ urlencode(' Join me on Aurelius — the trusted foodstuffs instalment platform that lets you shop with ease and pay flexibly.

Sign up through my link to start enjoying stress-free food shopping, instant rewards, and a chance to unlock something special.

 ' . $referralLink) }}" target="_blank">
        <i class="fab fa-facebook"></i> Facebook
    </a>

    <!-- Twitter -->
    <a href="https://twitter.com/intent/tweet?text={{ urlencode(' Join me on Aurelius — the trusted foodstuffs instalment platform that lets you shop with ease and pay flexibly.

Sign up through my link to start enjoying stress-free food shopping, instant rewards, and a chance to unlock something special.

' . $referralLink) }}" target="_blank">
        <i class="fab fa-twitter"></i> Twitter
    </a>

    <!-- Instagram -->
    <a href="#" onclick="copyReferralMessage();">
        <i class="fab fa-instagram"></i> Instagram
    </a>
</div>

<!-- Copy Link Button -->
<button class="copy-btn" onclick="copyLink()">
    <i class="far fa-copy"></i> Copy Link
</button>

<script>
function copyReferralMessage() {
    const message = `Join me on Aurelius — the trusted foodstuffs instalment platform that lets you shop with ease and pay flexibly.

Sign up through my link to start enjoying stress-free food shopping, instant rewards, and a chance to unlock something special.

{{ $referralLink }}`;

    navigator.clipboard.writeText(message);
    showSessionModal('success', 'Referral message copied! You can paste it on Instagram or anywhere you like.');
}
</script>



    </div>

    <div class="tabs">
        <div class="tab active" id="tabReferrals" onclick="switchTab('referrals')">My Referrals</div>
        <div class="tab" id="tabHistory" onclick="switchTab('history')">Earning History</div>
        <div class="tab" id="tabLeaders" onclick="switchTab('leaders')">Leaderboard</div>
    </div>

    <!-- My Referrals -->
    <div id="referrals" class="tab-content active">
        @if($myReferrals->count())
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myReferrals as $i => $ref)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $ref->referred->first_name ?? '' }} {{ $ref->referred->last_name ?? '' }}</td>
                        <td><span class="status {{ $ref->status }}">{{ ucfirst($ref->status) }}</span></td>
                        <td>{{ $ref->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p style="text-align:center; color:#999;">No referrals yet. Share your link to start earning!</p>
        @endif
    </div>

    <!-- Earning History -->
    <div id="history" class="tab-content">
        @if($history->count())
        <div class="table-responsive">
            <table>
                <thead><tr><th>#</th><th>Description</th><th>Amount</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($history as $i => $h)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $h->message }}</td>
                        <td><strong style="color:var(--primary);">₦{{ number_format($h->amount, 2) }}</strong></td>
                        <td>{{ $h->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
                        <td colspan="2"><strong style="color:var(--primary);">₦{{ number_format($totalEarnings, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <p style="text-align:center; color:#999;">No earning history yet.</p>
        @endif
    </div>

    <!-- Leaderboard -->
    <div id="leaders" class="tab-content">
        @if($leaders->count())
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Referrals</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaders as $i => $leader)
                    <tr>
                        <td>#{{ $i + 1 }}</td>
                        <td>{{ $leader->first_name }} {{ $leader->last_name }}</td>
                        <td><strong>{{ $leader->total }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p style="text-align:center; color:#999;">No leaderboard data yet.</p>
        @endif
    </div>
</div>

<!-- How It Works Modal -->
<div id="howItWorksModal" class="modal">
    <div class="modal-content">
        <h3>How It Works</h3>
        {!! $how_it_works !!}
        <button onclick="closeHowItWorks()">Close</button>
    </div>
</div>

<script>
function copyLink() {
    const link = document.getElementById("referralLink");
    link.select();
    document.execCommand("copy");
    showSessionModal("success", "Referral link copied!");
}
function switchTab(tab) {
    document.querySelectorAll(".tab, .tab-content").forEach(e => e.classList.remove("active"));
    document.getElementById("tab" + tab.charAt(0).toUpperCase() + tab.slice(1)).classList.add("active");
    document.getElementById(tab).classList.add("active");
}
function openHowItWorks() {
    document.getElementById("howItWorksModal").style.display = "flex";
}
function closeHowItWorks() {
    document.getElementById("howItWorksModal").style.display = "none";
}
window.onclick = function(e) {
    const modal = document.getElementById("howItWorksModal");
    if (e.target == modal) closeHowItWorks();
};
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.tab');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tab, .tab-content').forEach(e => e.classList.remove('active'));
      const target = tab.id.replace('tab', '').toLowerCase();
      tab.classList.add('active');
      document.getElementById(target).classList.add('active');
    });
  });
});
</script>

@endsection
