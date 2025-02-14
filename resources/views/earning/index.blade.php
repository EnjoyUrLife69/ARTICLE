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
                                <h3><b>$ 203.9</b>&nbsp;<i class='bx bx-trending-up bx-tada' style='color:#16d603'></i></h3>
                            </em></center>
                        <center>
                            <button class="btn btn-primary mt-3">
                                Withdraw Funds
                            </button>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Title</td>
                                        <td>Share</td>
                                        <td>Likes</td>
                                        <td>Views</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->title }}</td>
                                            <td>{{ $data->view_count }}</td>
                                            <td>{{ $data->like_count }}</td>
                                            <td>{{ $data->share_count }}</td>
                                            <td>${{ number_format($data->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
