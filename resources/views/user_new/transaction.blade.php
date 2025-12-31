@extends('user_new.app')

@section('content')
<div style="margin:0 auto;padding:1rem;">
    <!-- Header -->
   
    <!-- Filter Section -->
    <div style="
        display:flex;flex-wrap:wrap;gap:1rem;
        justify-content:space-between;align-items:center;
        margin-bottom:1.5rem;padding:1rem;
        background:#fff;border:1px solid #e2e8f0;
        border-radius:12px;box-shadow:0 1px 2px rgba(0,0,0,.05);
    ">
        <div style="flex:1;min-width:200px;">
            <div style="position:relative;display:flex;align-items:center;">
                <i class="fas fa-search" style="position:absolute;left:.75rem;color:#9ca3af;"></i>
                <input id="searchInput" type="text" placeholder="Search by reference, package..."
                    style="width:100%;padding:.7rem 1rem .7rem 2.5rem;
                        border:2px solid #e2e8f0;border-radius:8px;
                        font-size:.9rem;background:#f8fafc;">
            </div>
        </div>
        <button id="openFilterModal"
            style="padding:.7rem 1.2rem;border:none;border-radius:10px;
                font-weight:600;display:flex;align-items:center;gap:.5rem;
                background:linear-gradient(135deg,#ff7b00,#ff9800,#ffb84d);
                color:#fff;cursor:pointer;flex-shrink:0;">
            <i class="fas fa-filter"></i> Advanced Filters
        </button>
    </div>

    <!-- Table -->
    @if($payments && $payments->count() > 0)
        <div style="overflow-x:auto;background:#fff;border-radius:14px;border:1px solid #e2e8f0;">
            <table style="font-size:.85rem;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="padding:1rem;text-align:left;">Reference</th>
                        <th style="padding:1rem;">Package</th>
                        <th style="padding:1rem;">Gateway</th>
                        <th style="padding:1rem;">Amount</th>
                        <th style="padding:1rem;">Status</th>
                        <th style="padding:1rem;">Date</th>
                        {{-- <th style="padding:1rem;">Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr style="border-bottom:1px solid #f1f5f9;cursor:pointer;" class="table-row">
                            <td style="padding:1rem;font-weight:600;">{{ $payment->reference }}</td>
                            <td style="padding:1rem;">{{ ucfirst($payment->package) }}</td>
                            <td style="padding:1rem;"><span style="padding:.2rem .6rem;border-radius:6px;background:#e0f2fe;color:#2563eb;font-weight:600;">{{ ucfirst($payment->gateway) }}</span></td>
                            <td style="padding:1rem;font-weight:600;">₦{{ number_format($payment->amount,2) }}</td>
                            <td style="padding:1rem;">
                                <span style="border-radius:9999px;font-size:.75rem;font-weight:600;
                                    @if(strtolower($payment->status)=='success') background:#d1fae5;color:#047857; 
                                    @elseif(strtolower($payment->status)=='pending') background:#fef3c7;color:#b45309;
                                    @else background:#fee2e2;color:#b91c1c; @endif ">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td style="">{{ $payment->created_at->format('M j, Y g:i A') }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;display:flex;justify-content:center;">
        {{ $payments->links('admin.paginate') }}
        </div>
    @else
        <div style="text-align:center;padding:3rem;background:#fff;border-radius:14px;">
            <i class="fas fa-credit-card" style="font-size:3rem;opacity:.5;margin-bottom:.5rem;"></i>
            <h3 style="margin:.5rem 0;font-size:1.3rem;">No Payment History</h3>
            <p style="color:#6b7280;">You haven't made any payments yet.</p>
            <a href="{{ route('user.payment') }}" style="display:inline-flex;align-items:center;gap:.5rem;
                padding:.7rem 1.2rem;background:linear-gradient(135deg,#6366f1,#4f46e5);
                color:#fff;border-radius:10px;font-weight:600;text-decoration:none;">
                <i class="fas fa-sync"></i> Refresh
            </a>
        </div>
    @endif
</div>

<!-- Modal -->
<div id="filterModal" style="
    position:fixed;top:0;left:0;width:100%;height:100%;
    background:rgba(15,23,42,.8);display:none;
    align-items:center;justify-content:center;z-index:999;">
    <div style="background:#fff;padding:1.5rem;border-radius:16px;width:95%;max-width:700px;max-height:90vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h3 style="margin:0;font-size:1.2rem;font-weight:700;">Advanced Filters</h3>
            <span id="closeFilterModal" style="font-size:1.5rem;cursor:pointer;color:#6b7280;">&times;</span>
        </div>
        <form method="GET" action="{{ route('user.payment') }}" style="display:grid;gap:1rem;">
            <select name="status" style="padding:.7rem;border:1px solid #e2e8f0;border-radius:8px;">
                <option value="">All Statuses</option>
                <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
            </select>
            <select name="gateway" style="padding:.7rem;border:1px solid #e2e8f0;border-radius:8px;">
                <option value="">All Gateways</option>
                <option value="paystack" {{ request('gateway')=='paystack'?'selected':'' }}>Paystack</option>
                <option value="fincra" {{ request('gateway')=='fincra'?'selected':'' }}>Fincra</option>
                <option value="wallet" {{ request('gateway')=='wallet'?'selected':'' }}>Wallet</option>
            </select>
            
            <input type="date" name="date_from" value="{{ request('date_from') }}" style="padding:.7rem;border:1px solid #e2e8f0;border-radius:8px;">
            <input type="date" name="date_to" value="{{ request('date_to') }}" style="padding:.7rem;border:1px solid #e2e8f0;border-radius:8px;">
            <input type="number" name="amount_min" placeholder="Minimum amount" value="{{ request('amount_min') }}" style="padding:.7rem;border:1px solid #e2e8f0;border-radius:8px;">
            <input type="number" name="amount_max" placeholder="Maximum amount" value="{{ request('amount_max') }}" style="padding:.7rem;border:1px solid #e2e8f0;border-radius:8px;">

            <div style="display:flex;justify-content:flex-end;gap:1rem;margin-top:1rem;">
                <a href="{{ route('user.payment') }}" style="padding:.7rem 1.2rem;border:1px solid #e2e8f0;border-radius:8px;color:#374151;text-decoration:none;">Clear</a>
                <button type="submit" style="padding:.7rem 1.2rem;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:8px;font-weight:600;">Apply</button>
            </div>
        </form>
    </div>
</div>

<script>
const modal=document.getElementById('filterModal');
document.getElementById('openFilterModal').onclick=()=>{modal.style.display='flex';document.body.style.overflow='hidden'};
document.getElementById('closeFilterModal').onclick=()=>{modal.style.display='none';document.body.style.overflow='auto'};
window.onclick=(e)=>{if(e.target===modal){modal.style.display='none';document.body.style.overflow='auto'}};

document.getElementById('searchInput').addEventListener('input',function(){
  const term=this.value.toLowerCase();
  document.querySelectorAll('.table-row').forEach(r=>{
    r.style.display=r.textContent.toLowerCase().includes(term)?'':'none';
  });
});
</script>
@endsection
