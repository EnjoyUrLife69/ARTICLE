@extends('layouts.dashboard')

@section('styles')
    <style>
        .hover-edit {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .hover-edit .edit-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Overlay transparan */
            border-radius: 5%;
            /* Sesuai bentuk gambar */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
            /* Animasi smooth */
        }

        .hover-edit:hover .edit-overlay {
            opacity: 1;
            /* Tampilkan overlay saat hover */
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card" data-aos="zoom-in">
            <!-- Gambar Header -->
            <div class="card-header p-0" style="height: 220px; overflow: hidden;">
                <img src="{{ asset('assets/img/profile-banner.png') }}" alt="Cover Image"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <!-- Bagian Profil -->
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-2">
                        <div class="position-relative hover-edit" style="margin-top: -50px;">
                            <button class="border-0 bg-transparent p-0" data-bs-toggle="modal"
                                data-bs-target="#editProfileImageModal">
                                <img src="{{ asset('storage/images/users/' . $user->image) }}" alt="Profile Image"
                                    class="border border-5 border-white"
                                    style="border-radius: 5%; width: 135px; height: 135px; object-fit: cover;">
                                <div class="edit-overlay">
                                    <span><i class='bx bxs-edit-alt'></i> Update <br> Picture</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="col-10">
                        <h4 class="mt-3 mb-1 text-start"><b>{{ $user->name }}</b></h4>
                        <div class="row">
                            <div class="col-2">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        @php
                                            $roleClass = strtolower(str_replace(' ', '', $role)); // Menghapus spasi dan mengonversi role ke huruf kecil
                                        @endphp
                                        <p class="text-start mt-3">
                                            @php
                                                $icon = '';
                                                if ($roleClass == 'admin') {
                                                    $icon = "<i class='bx bxs-face'></i>";
                                                } elseif ($roleClass == 'superadmin') {
                                                    $icon = "<i class='bx bxs-crown'></i>";
                                                } elseif ($roleClass == 'writer') {
                                                    $icon = "<i class='bx bxs-edit-alt'></i>";
                                                }
                                            @endphp

                                            {!! $icon !!} &nbsp; {{ ucfirst($role) }}
                                        </p>
                                    @endforeach
                                @else
                                    <p class="text-muted">No Role Assigned</p>
                                @endif
                            </div>

                            <div class="col-10">
                                <p class="mt-3 mb-1 text-start"><i class='bx bxs-calendar'></i> &nbsp;Joined
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <div class="row ms-0" style="padding-left: 0.1rem;">
                    <div class="card" data-aos="zoom-in" data-aos-delay="200"
                        style="height: 3rem; display: flex; justify-content: center; align-items: center; font-size: 15px; ">
                        <b><em class="">ACCOUNT DETAIL</em></b>
                    </div>
                    <div class="card mt-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card-body">
                            <h6 style="font-size: 13px;" class="card-title text-muted">ABOUT</h6>
                            <table border="0">
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp; Name &nbsp;&nbsp;</td>
                                    <td>: &nbsp;&nbsp;&nbsp;</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-badge-check'></i> Status</td>
                                    <td>:</td>
                                    <td>
                                        <p class="text-start mt-3">Active
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-crown'></i> Role</td>
                                    <td>:</td>
                                    <td>
                                        @if ($roles->isNotEmpty())
                                            @foreach ($roles as $role)
                                                @php
                                                    $roleClass = strtolower(str_replace(' ', '', $role)); // Menghapus spasi dan mengonversi role ke huruf kecil
                                                @endphp

                                                {{ ucfirst($role) }}
                                            @endforeach
                                        @else
                                            <p class="text-muted">No Role Assigned</p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <h6 style="font-size: 13px;" class="card-title text-muted mt-4">CONTACT</h6>
                            <table>
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp; Email &nbsp;&nbsp;</td>
                                    <td>: &nbsp;&nbsp;&nbsp;</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row ms-0" style="padding-left: 0.1rem;">
                    <div class="card mt-3"
                        style="height: 3rem; display: flex; justify-content: center; align-items: center; font-size: 15px; ">
                        <b><em>OVERVIEW</em></b>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <table border="0">
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp;&nbsp;Article Uploaded&nbsp;&nbsp;&nbsp;</td>
                                    <td>: &nbsp;&nbsp;&nbsp;</td>
                                    <td><b>{{ $user->article->count() }}</b> Article (Total)</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-badge-check'></i>&nbsp;&nbsp;Article <b style="color: green;">Approved</b>
                                    </td>
                                    <td>:</td>
                                    <td><b>{{ $user->article()->status('approved')->count() }}</b> Article</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp;&nbsp;Article <b
                                            style="color: rgb(136, 136, 0);">Pending</b>
                                    </td>
                                    <td>:</td>
                                    <td><b>{{ $user->article()->status('pending')->count() }}</b> Article</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp;&nbsp;Article <b style="color: red;">Rejected</b>
                                    </td>
                                    <td>:</td>
                                    <td><b>{{ $user->article()->status('rejected')->count() }}</b> Article</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-show'></i>&nbsp;&nbsp;Article Views</td>
                                    <td>:</td>
                                    <td><b> {{$user->article->sum('view_count')}}</b>  Views</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card" data-aos-delay="300" data-aos="zoom-in">
                    <div class="card-body">
                        <div>
                            <i class='bx bx-bar-chart-alt-2'></i>&nbsp; Activity Timeline
                        </div>

                        <div id="activity-section">
                            @include('users.partials.activity', ['activities' => $activities])
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    </div>
    @include('users.modal-pp')
    @if (session('success'))
        <script type="text/javascript">
            showToast('Success!', '{{ session('success') }}', 'success');
        </script>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();

            let page = $(this).attr('href').split('page=')[1];
            fetchPage(page);
        });

        function fetchPage(page) {
            $.ajax({
                url: "?page=" + page,
                success: function(data) {
                    $('#activity-section').html(data);
                },
                error: function() {
                    alert('Failed to load data. Please try again.');
                }
            });
        }
    </script>

    <script>
        function fetchPage(page) {
            $('#loading-indicator').show(); // Tampilkan indikator loading
            $.ajax({
                url: "?page=" + page,
                success: function(data) {
                    $('#activity-section').html(data);
                    $('#loading-indicator').hide(); // Sembunyikan indikator setelah selesai
                },
                error: function() {
                    $('#loading-indicator').hide(); // Sembunyikan indikator jika ada error
                    alert('Failed to load data. Please try again.');
                }
            });
        }
    </script>
@endsection
