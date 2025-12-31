@extends('user_new.app')

@section('content')
<style>
    :root {
        --primary-color: #ff8c00; /* Orange */
        --secondary-color: #000000; /* Black */
    }

    .card-header {
        background-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .btn-success, .btn-outline-primary, .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .btn-outline-primary {
        background-color: transparent !important;
        color: var(--primary-color) !important;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color) !important;
        color: #fff !important;
    }

    .badge.bg-warning {
        background-color: #ffa500 !important;
        color: #000 !important;
    }

    table th {
        background: var(--secondary-color);
        color: #fff;
    }

    @media (max-width: 768px) {
        table thead {
            display: none;
        }
        table, table tbody, table tr, table td {
            display: block;
            width: 100%;
        }
        table tr {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #fff;
        }
        table td {
            text-align: right;
            position: relative;
            padding-left: 50%;
        }
        table td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            width: 45%;
            text-align: left;
            font-weight: bold;
            color: var(--secondary-color);
        }
        .btn {
            font-size: 12px;
            padding: 5px 8px;
        }
    }

    .modal-header {
        background-color: var(--primary-color);
        color: #fff;
    }
</style>

<div class="ec-content-wrapper">
    <div class="content">

        <!-- Back Button Row -->
        <div style="padding:20px;" class="breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-primary" onclick="history.back()">
                    ← Back
                </button>
                <h1 class="mb-0 mt-3">Terms & Conditions</h1>
            </div>
        </div>

        <div class="row p-3">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <p>{!! $term !!}</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
