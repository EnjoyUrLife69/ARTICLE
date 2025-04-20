@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="text-center mb-0">
                    <center class="mt-2" style="font-weight: bold">
                        <i class='bx bx-money-withdraw'
                            style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                        <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Penarikan Dana Penulis </em>
                    </center>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="{{ route('withdraw.store') }}" method="POST">
                    @csrf

                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="withdraw-form-container">
                        <div class="withdraw-form-layout">
                            <!-- Main Form Card (Left/Center) -->
                            <div class="withdraw-main-card">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- Available Balance --}}
                                        <div class="mb-4">
                                            <label for="balance" class="form-label">Saldo Tersedia</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control" id="balance"
                                                    value="{{ number_format($availableBalance, 0, ',', '.') }}" disabled
                                                    readonly>
                                            </div>
                                        </div>

                                        {{-- Withdrawal Amount --}}
                                        <div class="mb-4">
                                            <label class="form-label">Pilih Nominal Penarikan</label>
                                            <div class="row g-2">
                                                @php
                                                    $withdrawalAmounts = [
                                                        5000 => '5.000',
                                                        10000 => '10.000',
                                                        25000 => '25.000',
                                                        50000 => '50.000',
                                                        100000 => '100.000',
                                                        250000 => '250.000',
                                                        500000 => '500.000',
                                                    ];
                                                @endphp
                                                @foreach ($withdrawalAmounts as $amount => $formatted)
                                                    @if ($amount <= $availableBalance)
                                                        <div class="col-6 col-md-4">
                                                            <input type="radio" class="btn-check" name="amount"
                                                                id="amount-{{ $amount }}" value="{{ $amount }}"
                                                                autocomplete="off"
                                                                {{ old('amount') == $amount ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-primary w-100"
                                                                for="amount-{{ $amount }}">
                                                                Rp {{ $formatted }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @error('amount')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Payment Method --}}
                                        <div class="mb-4">
                                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                                id="payment_method" name="payment_method" required>
                                                <option value="" selected disabled>Pilih Metode Pembayaran</option>
                                                <option value="bank_transfer"
                                                    {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>
                                                    Transfer Bank
                                                </option>
                                                <option value="e-wallet"
                                                    {{ old('payment_method') == 'e-wallet' ? 'selected' : '' }}>
                                                    E-Wallet
                                                </option>
                                            </select>
                                            @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('withdraw.index') }}" class="btn btn-secondary">
                                                <i class="bx bx-arrow-back me-1"></i> Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-check me-1"></i> Ajukan Penarikan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Cards (Right Side) -->
                            <div class="withdraw-details-container">
                                {{-- Bank Details Section --}}
                                <div id="bankDetails" class="withdraw-details-card d-none">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">Detail Rekening Bank</h6>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="bank_name" class="form-label">Nama Bank</label>
                                                    <select class="form-select @error('bank_name') is-invalid @enderror"
                                                        id="bank_name" name="bank_name">
                                                        <option value="" selected disabled>Pilih Bank</option>
                                                        @php
                                                            $banks = [
                                                                'BCA',
                                                                'BNI',
                                                                'BRI',
                                                                'Mandiri',
                                                                'CIMB Niaga',
                                                                'BTN',
                                                            ];
                                                        @endphp
                                                        @foreach ($banks as $bank)
                                                            <option value="{{ $bank }}"
                                                                {{ old('bank_name') == $bank ? 'selected' : '' }}>
                                                                {{ $bank }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('bank_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="account_number" class="form-label">Nomor Rekening</label>
                                                    <input type="text"
                                                        class="form-control @error('account_number') is-invalid @enderror"
                                                        id="account_number" name="account_number"
                                                        placeholder="Masukkan Nomor Rekening"
                                                        value="{{ old('account_number') }}">
                                                    @error('account_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="account_name" class="form-label">Nama Pemilik
                                                        Rekening</label>
                                                    <input type="text"
                                                        class="form-control @error('account_name') is-invalid @enderror"
                                                        id="account_name" name="account_name"
                                                        placeholder="Nama Sesuai Rekening"
                                                        value="{{ old('account_name') }}">
                                                    @error('account_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- E-Wallet Details Section --}}
                                <div id="ewalletDetails" class="withdraw-details-card d-none">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">Detail E-Wallet</h6>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="ewallet_type" class="form-label">Pilih E-Wallet</label>
                                                    <select class="form-select @error('ewallet_type') is-invalid @enderror"
                                                        id="ewallet_type" name="ewallet_type">
                                                        <option value="" selected disabled>Pilih E-Wallet</option>
                                                        @php
                                                            $ewallets = [
                                                                'GoPay',
                                                                'OVO',
                                                                'DANA',
                                                                'LinkAja',
                                                                'ShopeePay',
                                                            ];
                                                        @endphp
                                                        @foreach ($ewallets as $ewallet)
                                                            <option value="{{ $ewallet }}"
                                                                {{ old('ewallet_type') == $ewallet ? 'selected' : '' }}>
                                                                {{ $ewallet }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('ewallet_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">+62</span>
                                                        <input type="text"
                                                            class="form-control @error('phone_number') is-invalid @enderror"
                                                            id="phone_number" name="phone_number"
                                                            placeholder="8xxxxxxxxxx" value="{{ old('phone_number') }}">
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Masukkan nomor tanpa awalan 0 atau +62
                                                    </small>
                                                    @error('phone_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Container utama dengan overflow hidden untuk menghindari scrollbar horizontal saat animasi */
        .withdraw-form-container {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        /* Layout utama menggunakan grid untuk posisi yang lebih presisi */
        .withdraw-form-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 100%;
            transition: all 0.5s ease;
        }

        /* Posisi awal card utama di tengah */
        .withdraw-main-card {
            grid-column: 1 / 3;
            max-width: 600px;
            margin: 0 auto;
            transition: all 0.5s ease;
            z-index: 10;
        }

        /* Container untuk card detail */
        .withdraw-details-container {
            grid-column: 2;
            grid-row: 1;
            opacity: 0;
            transition: all 0.5s ease;
            z-index: 5;
        }

        /* Card detail */
        .withdraw-details-card {
            width: 100%;
            transition: all 0.5s ease;
            transform: translateX(50px);
        }

        /* Layout setelah dipilih metode pembayaran */
        .withdraw-form-layout.active {
            grid-template-columns: 1fr 1fr;
        }

        .withdraw-form-layout.active .withdraw-main-card {
            grid-column: 1;
            margin: 0;
            transform: translateX(0);
            max-width: 100%;
        }

        .withdraw-form-layout.active .withdraw-details-container {
            opacity: 1;
            visibility: visible;
        }

        .withdraw-details-card.active {
            transform: translateX(0);
        }

        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            .withdraw-form-layout {
                display: flex;
                flex-direction: column;
            }

            .withdraw-main-card {
                width: 100%;
                max-width: 100%;
                margin: 0 0 20px 0;
            }

            .withdraw-details-container {
                width: 100%;
                opacity: 0;
                height: 0;
                overflow: hidden;
                transition: all 0.5s ease;
            }

            .withdraw-form-layout.active .withdraw-details-container {
                opacity: 1;
                height: auto;
                overflow: visible;
            }

            .withdraw-details-card {
                transform: translateY(20px);
            }

            .withdraw-details-card.active {
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('payment_method');
            const bankDetails = document.getElementById('bankDetails');
            const ewalletDetails = document.getElementById('ewalletDetails');
            const formLayout = document.querySelector('.withdraw-form-layout');
            const detailsContainer = document.querySelector('.withdraw-details-container');

            // Fungsi untuk mengatur visibilitas form dan required fields
            function updateFormVisibility() {
                // Reset semua card detail
                document.querySelectorAll('.withdraw-details-card').forEach(card => {
                    card.classList.remove('active');
                    card.classList.add('d-none');
                });

                // Reset layout
                formLayout.classList.remove('active');

                if (paymentMethod.value === 'bank_transfer') {
                    // Aktifkan layout untuk tampilan side-by-side
                    formLayout.classList.add('active');

                    // Tampilkan detail bank
                    bankDetails.classList.remove('d-none');
                    setTimeout(() => {
                        bankDetails.classList.add('active');
                    }, 50);

                    // Aktifkan validasi untuk form bank
                    document.getElementById('bank_name').setAttribute('required', 'required');
                    document.getElementById('account_number').setAttribute('required', 'required');
                    document.getElementById('account_name').setAttribute('required', 'required');

                    // Nonaktifkan validasi untuk form e-wallet
                    document.getElementById('ewallet_type').removeAttribute('required');
                    document.getElementById('phone_number').removeAttribute('required');

                } else if (paymentMethod.value === 'e-wallet') {
                    // Aktifkan layout untuk tampilan side-by-side
                    formLayout.classList.add('active');

                    // Tampilkan detail e-wallet
                    ewalletDetails.classList.remove('d-none');
                    setTimeout(() => {
                        ewalletDetails.classList.add('active');
                    }, 50);

                    // Aktifkan validasi untuk form e-wallet
                    document.getElementById('ewallet_type').setAttribute('required', 'required');
                    document.getElementById('phone_number').setAttribute('required', 'required');

                    // Nonaktifkan validasi untuk form bank
                    document.getElementById('bank_name').removeAttribute('required');
                    document.getElementById('account_number').removeAttribute('required');
                    document.getElementById('account_name').removeAttribute('required');
                }
            }

            // Event listener untuk perubahan pada pilihan metode pembayaran
            paymentMethod.addEventListener('change', updateFormVisibility);

            // Jalankan sekali pada saat load untuk mengatur status awal (jika ada nilai old)
            if (paymentMethod.value) {
                updateFormVisibility();
            }
        });
    </script>
@endsection
