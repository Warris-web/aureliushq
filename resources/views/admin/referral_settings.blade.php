@extends('admin.app')

@section('content')
<style>
    .settings-wrapper {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: 10px;
        padding: 2rem;
        max-width: 900px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }

    .settings-header h2 {
        font-weight: 600;
        color: #111827;
        font-size: 1.5rem;
    }

    form label {
        font-weight: 500;
        color: #374151;
        display: block;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 0.7rem 0.9rem;
        width: 100%;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        outline: none;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    textarea.form-control {
        resize: vertical;
    }

    .btn-primary {
        background-color: darkorange;
        color: #fff;
        border: none;
        padding: 0.8rem 1.6rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: ;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
</style>

<div class="settings-wrapper">
    <div class="settings-header">
        <h2>
         Referral Settings</h2>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('referral.settings.update') }}">
        @csrf

        <div class="form-grid">
            <div>
                <label>Referrer Reward (₦)</label>
                <input type="number" step="0.01" name="referrer_reward" value="{{ $settings->referrer_reward }}" class="form-control" required>
            </div>

            <div>
                <label>Referred Reward (₦)</label>
                <input type="number" step="0.01" name="referred_reward" value="{{ $settings->referred_reward }}" class="form-control" required>
            </div>

            <div>
                <label>Commission Percentage (%)</label>
                <input type="number" step="0.01" name="commission_percentage" value="{{ $settings->commission_percentage }}" class="form-control" required>
            </div>

            <div>
                <label>Display Referral Note</label>
                <select name="display_referral_note" class="form-control">
                    <option value="yes" {{ $settings->display_referral_note == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ $settings->display_referral_note == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div>
            <label>Referral Note</label>
            <textarea id="myTextarea" name="referral_note" rows="4" class="form-control">{{ $settings->referral_note }}</textarea>
        </div>
        <div>
            <label>How it Works</label>
            <textarea id="myTextarea2" name="how_it_works" rows="4" class="form-control">{{ $settings->how_it_works }}</textarea>
        </div>


<div class="mt-2">
            <label>Term of Use</label>
            <textarea id="myTextarea3" name="term_of_use" rows="4" class="form-control">{{ $settings->term_of_use }}</textarea>
        </div>


        <div style="margin-top:1.8rem;text-align:right;">
            <button type="submit" class="btn-primary">
                <i class="mdi mdi-content-save-outline" style="margin-right:4px;"></i> Update Settings
            </button>
        </div>
    </form>
</div>
@endsection
