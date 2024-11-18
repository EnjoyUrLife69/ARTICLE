@extends('layouts.dashboard')

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
                        <div class="position-relative" style="margin-top: -50px;">
                            <img src="{{ asset('storage/images/users/' . $user->image) }}" alt="Profile Image"
                                class="border border-5 border-white"
                                style="border-radius: 5%; width: 135px; height: 135px; object-fit: cover;">
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

                            <div class="col-5">
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
                    <div class="card" data-aos="zoom-in" data-aos-delay="200">
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
                    <div class="card mt-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card-body">
                            <h6 style="font-size: 13px;" class="card-title text-muted">OVERVIEW</h6>
                            <table border="0">
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp;&nbsp;Article Uploaded&nbsp;&nbsp;&nbsp;</td>
                                    <td>: &nbsp;&nbsp;&nbsp;</td>
                                    <td><b>{{ $user->article->count() }}</b> Article</td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp;&nbsp;Article <b style="color: green;">Approved</b>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <b>{{ $user->article()->status('approved')->count() }}</b> Article
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-user'></i>&nbsp;&nbsp;Article <b style="color: red;">Rejected</b>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <b>{{ $user->article()->status('rejected')->count() }}</b> Article
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class='bx bx-badge-check'></i>&nbsp;&nbsp; View</td>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <em>-- coming soon --</em>
                                    </td>
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
                        @if ($activities->isEmpty())
                            <center><em>No activity yet. Stay tuned!</em></center>
                        @else
                            @foreach ($activities as $data)
                                <div style="display: flex; align-items: center; margin-top: 16px;">
                                    <div class="dot"></div>
                                    <b class="ms-3">{{ ucfirst($data->action) }} an Article</b>
                                    <em style="margin-left: auto;">{{ $data->created_at->diffForHumans() }}</em>
                                </div>
                                <div class="d-flex">
                                    <div class="vl"></div> <!-- Vertical line -->
                                    <div class="ms-1">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="ms-4 mt-2">{!! $data->details !!}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <img class="ms-4"
                                                    src="{{ asset('storage/images/articles/' . $data->img) }}"
                                                    width="103" alt="img"
                                                    style="border: 2px solid #E4E6E8; border-radius: 4px;">
                                            </div>
                                            <div class="col-10">
                                                <div class="row">
                                                    <div class="col-12 ms-4">
                                                        <em>" {{ $data->description }} "</em>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <span class="badge bg-primary ms-4">{{ $data->categorie_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>

    </div>
@endsection
