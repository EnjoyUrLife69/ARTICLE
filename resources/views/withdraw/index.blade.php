@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bx-history'
                                style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Riwayat Penarikan </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>

        @if (session('success'))
            <script type="text/javascript">
                showToast('Success!', '{{ session('success') }}', 'success');
            </script>
        @endif

        @if (session('error'))
            <script type="text/javascript">
                showToast('Error!', '{{ session('error') }}', 'error');
            </script>
        @endif

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <center><em><b style="color: rgb(172, 172, 172);">Saldo Tersedia</b></em></center><br>
                        <center><em>
                                <h3><b>Rp. {{ number_format($availableBalance, 2, ',', '.') }}</b>&nbsp;
                                    <i class='bx bx-wallet' style='color:#16d603'></i>
                                </h3>
                            </em></center>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Penghasilan:</span>
                            <span>Rp. {{ number_format($totalEarnings, 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Penarikan:</span>
                            <span>Rp. {{ number_format($totalWithdrawn, 2, ',', '.') }}</span>
                        </div>
                        <center>
                            <a href="{{ route('withdraw.create') }}" class="btn btn-primary mt-3">
                                <i class='bx bx-money-withdraw'></i> Tarik Dana
                            </a>
                        </center>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($withdraws as $withdraw)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $withdraw->created_at->format('d M Y, H:i') }}</td>
                                            <td>{{ $withdraw->formatted_amount }}</td>
                                            <td>
                                                @if ($withdraw->payment_method == 'bank_transfer')
                                                    <i class='bx bxs-bank'></i> {{ $withdraw->bank_name }}
                                                @else
                                                    <i class='bx bx-wallet'></i> {{ $withdraw->ewallet_type }}
                                                @endif
                                            </td>
                                            <td>{!! $withdraw->status_badge !!}</td>
                                            <td>
                                                <a href="{{ route('withdraw.show', $withdraw->id) }}" class="btn btn-sm btn-info">
                                                    <i class='bx bx-show'></i>
                                                </a>
                                                
                                                @if ($withdraw->status == 'pending')
                                                    <form action="{{ route('withdraw.cancel', $withdraw->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan penarikan ini?')">
                                                            <i class='bx bx-x'></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada riwayat penarikan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3">
                            {{ $withdraws->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection