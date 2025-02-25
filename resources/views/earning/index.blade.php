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
                        <center><em><b style="color: rgb(172, 172, 172);">Your Balance</b></em></center><br>
                        <center><em>
                                <h3><b>Rp. {{ number_format($totalEarnings, 2) }}</b>&nbsp;<i
                                        class='bx bx-trending-up bx-tada' style='color:#16d603'></i></h3>
                            </em></center>
                        <center>
                            <button class="btn btn-primary mt-3">
                                Withdraw Funds
                            </button>
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
                                <i class='bx bx-share-alt'></i> <b> Rp. 750 </b>/ share
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
@endsection
