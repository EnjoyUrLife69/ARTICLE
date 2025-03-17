@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bxs-wallet'
                                style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Earning's </em>
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
        <div class="row">
            <div class="col-3">
                <div class="card mt-4">
                    <div class="card-body">
                        <center><em><b style="color: rgb(172, 172, 172);">Saldo Anda</b></em></center><br>
                        <center><em>
                                <h3><b>Rp. {{ number_format($totalEarnings, 2, ',', '.') }}</b>&nbsp;<i
                                        class='bx bx-trending-up bx-tada' style='color:#16d603'></i></h3>
                            </em></center>
                        <center>
                            <a href="{{ route('withdraw.create') }}" class="btn btn-primary mt-3">
                                <i class='bx bx-money-withdraw'></i> Tarik Dana
                            </a>
                            <a href="{{ route('withdraw.index') }}" class="btn btn-secondary mt-3">
                                <i class='bx bx-history'></i> Riwayat Penarikan
                            </a>
                        </center>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <center><em><b style="color: rgb(172, 172, 172);">Interaction Pricing</b></em></center><br>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class='bx bx-show'></i> <b> Rp. 15 </b> / view
                            </li>
                            <li class="list-group-item">
                                <i class='bx bx-like'></i> <b> Rp. 150 </b> / like
                            </li>
                            <li class="list-group-item">
                                <i class='bx bx-share-alt'></i> <b> Rp. 550 </b>/ share
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-9">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="viewMode">
                                <label class="form-check-label" for="viewMode">Display in Rupiah</label>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Title</td>
                                        <td>
                                            <center>Views</center>
                                        </td>
                                        <td>
                                            <center>Likes</center>
                                        </td>
                                        <td>
                                            <center>Shares</center>
                                        </td>
                                        <td>
                                            <center>Total Earning</center>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->title }}</td>
                                            <td>
                                                <center>
                                                    <span class="count-view">{{ $data->view_count }} x</span>
                                                    <span class="money-view"
                                                        style="display: none">Rp.{{ number_format($data->view_count * \App\Models\Article::VIEW_RATE, 2) }}</span>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <span class="count-view">{{ $data->like_count }} x</span>
                                                    <span class="money-view"
                                                        style="display: none">Rp.{{ number_format($data->like_count * \App\Models\Article::LIKE_RATE, 2) }}</span>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <span class="count-view">{{ $data->share_count }} x</span>
                                                    <span class="money-view"
                                                        style="display: none">Rp.{{ number_format($data->share_count * \App\Models\Article::SHARE_RATE, 2) }}</span>
                                                </center>
                                            </td>
                                            <td>
                                                <center>Rp.{{ number_format($data->total, 2) }}</center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <script>
                            document.getElementById('viewMode').addEventListener('change', function() {
                                const countViews = document.querySelectorAll('.count-view');
                                const moneyViews = document.querySelectorAll('.money-view');

                                countViews.forEach(view => {
                                    view.style.display = this.checked ? 'none' : '';
                                });

                                moneyViews.forEach(view => {
                                    view.style.display = this.checked ? '' : 'none';
                                });
                            });
                        </script>

                        <script>
                            // Inisialisasi tooltip Bootstrap
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl)
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">Penarikan Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('withdraw.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="balance" class="form-label">Saldo Tersedia</label>
                            <input type="text" class="form-control" id="balance"
                                value="Rp. {{ number_format($totalEarnings, 2) }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah Penarikan</label>
                            <input type="number" class="form-control" id="amount" name="amount" required min="10000"
                                max="{{ $totalEarnings }}">
                            <div class="form-text">Minimal penarikan Rp. 10.000</div>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="" selected disabled>Pilih metode pembayaran</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                        </div>
                        <div id="bankDetails" class="mb-3 d-none">
                            <label for="bank_name" class="form-label">Nama Bank</label>
                            <select class="form-select" id="bank_name" name="bank_name">
                                <option value="" selected disabled>Pilih bank</option>
                                <option value="BCA">BCA</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                                <option value="Mandiri">Mandiri</option>
                            </select>
                            <div class="mt-2">
                                <label for="account_number" class="form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" id="account_number" name="account_number">
                            </div>
                            <div class="mt-2">
                                <label for="account_name" class="form-label">Nama Pemilik Rekening</label>
                                <input type="text" class="form-control" id="account_name" name="account_name">
                            </div>
                        </div>
                        <div id="ewalletDetails" class="mb-3 d-none">
                            <label for="ewallet_type" class="form-label">Jenis E-Wallet</label>
                            <select class="form-select" id="ewallet_type" name="ewallet_type">
                                <option value="" selected disabled>Pilih E-Wallet</option>
                                <option value="GoPay">GoPay</option>
                                <option value="OVO">OVO</option>
                                <option value="DANA">DANA</option>
                                <option value="LinkAja">LinkAja</option>
                            </select>
                            <div class="mt-2">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tarik Dana</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            const bankDetails = document.getElementById('bankDetails');
            const ewalletDetails = document.getElementById('ewalletDetails');

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
    </script>
@endsection
