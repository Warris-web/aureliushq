@extends('auth.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header  text-center">
<div class="ec-brand">
								<a href="" title="Ekka">

									<img style="padding:10px;" class="ec-brand-icon" src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="" />
								</a>
							</div>                </div>
                <div class="card-body p-4">

                    {{-- ✅ Success / Error Alerts --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('package.submit') }}" enctype="multipart/form-data" id="packageForm">
                        @csrf

                        {{-- ✅ Package Selection --}}
                        <div class="form-group mb-3">
                            <label>Select Package</label>
                            <select name="package" id="package" class="form-control" required>
                                <option value="">-- Select Package --</option>
                                @foreach($packages as $key => $package)
                                    <option value="{{ $key }}">{{ $package['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ✅ Package Info --}}
                        <div id="packageDetails" class="border p-3 rounded bg-light mb-3" style="display:none;">
                            <h5 id="packageName" class="text-primary"></h5>
                            <p id="packageInfo" class="mb-1"></p>
                            <ul id="repaymentOptions" class="pl-3"></ul>
                        </div>

                        {{-- ✅ ID Card Upload --}}
                        <div class="form-group mb-3">
                            <label>Upload ID Card</label>
                            <input type="file" name="id_card" class="form-control" required>
                        </div>

                        <div class="alert alert-info">
                            <strong>Onboarding Fee:</strong> ₦500 (required to proceed)
                        </div>

                        {{-- ✅ Fincra Checkout Button --}}
                        <button type="submit"  class="btn btn-success btn-block">Make Payment</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Dynamic Package Details --}}
<script>
const packages = @json($packages);

document.getElementById('package').addEventListener('change', function(){
    const val = this.value;
    const details = document.getElementById('packageDetails');
    if(packages[val]){
        document.getElementById('packageName').textContent = packages[val].name;
        document.getElementById('packageInfo').textContent = packages[val].info;
        document.getElementById('repaymentOptions').innerHTML = packages[val].options.map(o=>`<li>${o}</li>`).join('');
        details.style.display = 'block';
    } else {
        details.style.display = 'none';
    }
});

</script>

<script src="https://checkout.fincra.com/static/js/fincra-checkout.js"></script>
@endsection
