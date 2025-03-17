@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bx-money-withdraw'
                                style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Tarik Dana </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('withdraw.store') }}" method="POST">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="balance" class="form-label">Saldo Tersedia</label>
                                <input type="text" class="form-control" id="balance"
                                    value="Rp. {{ number_format($availableBalance, 2, ',', '.') }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah Penarikan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" name="amount" required min="{{ $minWithdraw }}"
                                        max="{{ $availableBalance }}" value="{{ old('amount', $minWithdraw) }}"
                                        placeholder="Masukkan jumlah penarikan">
                                </div>
                                <div class="form-text">
                                    @if ($availableBalance < 10000)
                                        Minimal penarikan adalah seluruh saldo Anda (Rp.
                                        {{ number_format($minWithdraw, 0, ',', '.') }})
                                    @else
                                        Minimal penarikan Rp. {{ number_format($minWithdraw, 0, ',', '.') }}
                                    @endif
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror"
                                    id="payment_method" name="payment_method" required>
                                    <option value="" selected disabled>Pilih metode pembayaran</option>
                                    <option value="bank_transfer"
                                        {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank
                                    </option>
                                    <option value="e-wallet" {{ old('payment_method') == 'e-wallet' ? 'selected' : '' }}>
                                        E-Wallet</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Detail Bank Transfer -->
                            <div id="bankDetails"
                                class="mb-3 {{ old('payment_method') == 'bank_transfer' ? '' : 'd-none' }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3">Detail Rekening Bank</h6>

                                        <div class="mb-3">
                                            <label for="bank_name" class="form-label">Nama Bank</label>
                                            <select class="form-select @error('bank_name') is-invalid @enderror"
                                                id="bank_name" name="bank_name">
                                                <option value="" selected disabled>Pilih bank</option>
                                                <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>
                                                    BCA</option>
                                                <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>
                                                    BNI</option>
                                                <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>
                                                    BRI</option>
                                                <option value="Mandiri"
                                                    {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                <option value="CIMB Niaga"
                                                    {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga
                                                </option>
                                                <option value="BTN" {{ old('bank_name') == 'BTN' ? 'selected' : '' }}>
                                                    BTN</option>
                                            </select>
                                            @error('bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="account_number" class="form-label">Nomor Rekening</label>
                                            <input type="text"
                                                class="form-control @error('account_number') is-invalid @enderror"
                                                id="account_number" name="account_number"
                                                value="{{ old('account_number') }}">
                                            @error('account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="account_name" class="form-label">Nama Pemilik Rekening</label>
                                            <input type="text"
                                                class="form-control @error('account_name') is-invalid @enderror"
                                                id="account_name" name="account_name" value="{{ old('account_name') }}">
                                            @error('account_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail E-Wallet -->
                            <div id="ewalletDetails"
                                class="mb-3 {{ old('payment_method') == 'e-wallet' ? '' : 'd-none' }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3">Detail E-Wallet</h6>

                                        <div class="mb-3">
                                            <label for="ewallet_type" class="form-label">Jenis E-Wallet</label>
                                            <select class="form-select @error('ewallet_type') is-invalid @enderror"
                                                id="ewallet_type" name="ewallet_type">
                                                <option value="" selected disabled>Pilih E-Wallet</option>
                                                <option value="GoPay"
                                                    {{ old('ewallet_type') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                                <option value="OVO"
                                                    {{ old('ewallet_type') == 'OVO' ? 'selected' : '' }}>OVO</option>
                                                <option value="DANA"
                                                    {{ old('ewallet_type') == 'DANA' ? 'selected' : '' }}>DANA</option>
                                                <option value="LinkAja"
                                                    {{ old('ewallet_type') == 'LinkAja' ? 'selected' : '' }}>LinkAja
                                                </option>
                                                <option value="ShopeePay"
                                                    {{ old('ewallet_type') == 'ShopeePay' ? 'selected' : '' }}>ShopeePay
                                                </option>
                                            </select>
                                            @error('ewallet_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input type="text"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    id="phone_number" name="phone_number"
                                                    value="{{ old('phone_number') }}" placeholder="8xxxxxxxxxx">
                                            </div>
                                            <div class="form-text">Masukkan nomor tanpa awalan 0 atau +62</div>
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('withdraw.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Ajukan Penarikan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentMethod = document.getElementById('payment_method');
                const bankDetails = document.getElementById('bankDetails');
                const ewalletDetails = document.getElementById('ewalletDetails');

                paymentMethod.addEventListener('change', function() {
                    if (this.value === 'bank_transfer') {
                        bankDetails.classList.remove('d-none');
                        ewalletDetails.classList.add('d-none');
                    } else if (this.value === 'e-wallet') {
                        ewalletDetails.classList.remove('d-none');
                        bankDetails.classList.add('d-none');
                    } else {
                        bankDetails.classList.add('d-none');
                        ewalletDetails.classList.add('d-none');
                    }
                });
            });
        </script>
    @endpush
@endsection
