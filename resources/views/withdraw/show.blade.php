@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white text-center py-4 border-0">
                        <h2 class="h4 mb-0 text-dark">
                            <i class='bx bx-detail text-primary me-2'></i>Withdrawal Details
                        </h2>
                    </div>

                    <div class="card-body p-4">
                        {{-- Status and Basic Information --}}
                        <div class="mb-4 text-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                                    {!! $withdraw->status_badge !!}
                                </span>
                            </div>

                            {{-- Logo Container --}}
                            <div class="mb-3 d-flex justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 100 100"
                                    class="withdrawal-logo">
                                    <circle cx="50" cy="50" r="45" fill="#4CAF50" />
                                    <path d="M50 30 L55 45 Q50 50 45 45 Z" fill="#FFFFFF" />
                                    <text x="50" y="70" text-anchor="middle" font-size="20" fill="#FFFFFF">
                                        Rp
                                    </text>
                                </svg>
                            </div>

                            <h3 class="text-dark mb-2">{{ $withdraw->formatted_amount }}</h3>
                            <p class="text-muted small">
                                Processed on
                                {{ $withdraw->processed_at instanceof \Carbon\Carbon
                                    ? $withdraw->processed_at->format('d M Y, H:i')
                                    : \Carbon\Carbon::parse($withdraw->processed_at)->format('d M Y, H:i') }}
                            </p>
                        </div>

                        {{-- Withdrawal Information --}}
                        <div class="bg-light rounded-3 p-3 mb-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Withdrawal ID</small>
                                    <span class="fw-bold">{{ $withdraw->id }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted d-block">Request Date</small>
                                    <span class="fw-bold">{{ $withdraw->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Details --}}
                        <div class="card border-0 bg-soft-success mb-4">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        @if ($withdraw->payment_method == 'bank_transfer')
                                            <i class='bx bxs-bank text-success fs-2'></i>
                                        @else
                                            <i class='bx bx-wallet text-success fs-2'></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        @if ($withdraw->payment_method == 'bank_transfer')
                                            <h6 class="mb-1">{{ $withdraw->bank_name }}</h6>
                                            <p class="mb-0 small text-muted">
                                                {{ $withdraw->account_number }}
                                                ({{ $withdraw->account_name }})
                                            </p>
                                        @else
                                            <h6 class="mb-1">{{ $withdraw->ewallet_type }}</h6>
                                            <p class="mb-0 small text-muted">+62{{ $withdraw->phone_number }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Additional Notes --}}
                        @if ($withdraw->notes)
                            <div class="alert alert-light border-0 mb-4" role="alert">
                                <i class='bx bx-note me-2'></i>
                                <span>{{ $withdraw->notes }}</span>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('withdraw.index') }}" class="btn btn-outline-secondary me-2">
                                <i class='bx bx-arrow-back me-1'></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-soft-primary {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .bg-soft-success {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05) !important;
        }

        .withdrawal-logo {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
        }

        .withdrawal-logo:hover {
            transform: scale(1.1);
        }
    </style>
@endsection
