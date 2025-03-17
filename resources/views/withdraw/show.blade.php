@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bx-detail'
                                style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Detail Penarikan </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Status Penarikan:</span>
                                <span>{!! $withdraw->status_badge !!}</span>
                            </div>
                            
                            @if($withdraw->processed_at)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold">Tanggal Diproses:</span>
                                    <span>{{ $withdraw->processed_at->format('d M Y, H:i') }}</span>
                                </div>
                            @endif
                            
                            @if($withdraw->notes)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold">Catatan:</span>
                                    <span>{{ $withdraw->notes }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Informasi Penarikan</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>ID Penarikan:</span>
                                    <span>{{ $withdraw->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Tanggal Permintaan:</span>
                                    <span>{{ $withdraw->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Jumlah Penarikan:</span>
                                    <span class="fw-bold text-primary">{{ $withdraw->formatted_amount }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    @if($withdraw->payment_method == 'bank_transfer')
                                        <i class='bx bxs-bank'></i> Detail Rekening Bank
                                    @else
                                        <i class='bx bx-wallet'></i> Detail E-Wallet
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($withdraw->payment_method == 'bank_transfer')
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Nama Bank:</span>
                                        <span>{{ $withdraw->bank_name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Nomor Rekening:</span>
                                        <span>{{ $withdraw->account_number }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Atas Nama:</span>
                                        <span>{{ $withdraw->account_name }}</span>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Jenis E-Wallet:</span>
                                        <span>{{ $withdraw->ewallet_type }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Nomor Telepon:</span>
                                        <span>+62{{ $withdraw->phone_number }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('withdraw.index') }}" class="btn btn-secondary">Kembali</a>
                            
                            @if($withdraw->status == 'pending')
                                <form action="{{ route('withdraw.cancel', $withdraw->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan penarikan ini?')">
                                        <i class='bx bx-x'></i> Batalkan Penarikan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection