@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bxs-user' style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> User Management </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>
        <!-- Bordered Table -->
        <div class="card mt-3">
            <div class="row" style="margin-top: 10px;">
                <div class="col-10">
                    <h5 class="card-header">Data User Tables</h5>
                </div>
                {{-- CREATE DATA --}}
                <div class="col-2">
                    <div class="mt-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                            <i class='bx bx-plus-circle'></i> Add Data
                        </button>

                        @include('users.modal-create')
                    </div>
                </div>
                {{-- END CREATE DATA --}}
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>
                                    <center>No</center>
                                </th>
                                <th>&nbsp;&nbsp;&nbsp;</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>
                                        <center>{{ $loop->iteration }}</center>
                                    </td>
                                    <td>
                                        <img src="{{ $user->image_url }}" alt="Profile Image"
                                            class="img-fluid rounded-circle" width="80px" height="80px"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->name }}">
                                    </td>
                                    <td>
                                        <b>{{ $user->name }}</b>
                                    </td>
                                    <td><b>{{ $user->email }}</b></td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                @php
                                                    $role = strtolower(str_replace(' ', '', $v)); // Menghapus spasi dan mengonversi role ke huruf kecil
                                                @endphp
                                                <label
                                                    class="badge 
                                                        @if ($role == 'guest') bg-primary
                                                        @elseif($role == 'superadmin') bg-danger
                                                        @elseif($role == 'writer') bg-info
                                                        @else bg-success @endif">
                                                    {{ ucfirst($v) }}
                                                </label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        {{-- SHOW DATA --}}
                                        @can('user-edit')
                                            <button type="button" class="btn btn-sm btn-warning"
                                                data-bs-target="#Show{{ $user->id }}" data-bs-toggle="modal">
                                                <i class='bx bx-show-alt' data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Show" data-bs-offset="0,4" data-bs-html="true"></i>
                                            </button>
                                        @endcan

                                        {{-- EDIT DATA --}}
                                        @can('user-edit')
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-bs-target="#Edit{{ $user->id }}" data-bs-toggle="modal">
                                                <i class='bx bx-edit' data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit" data-bs-offset="0,4" data-bs-html="true"></i>
                                            </button>
                                        @endcan

                                        {{-- DELETE DATA --}}
                                        @can('user-delete')
                                            @if (auth()->id() != $user->id)
                                                <form id="deleteForm{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        id="deleteButton{{ $user->id }}" data-bs-toggle="tooltip"
                                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                        title="<span>Delete</span>">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan


                                        <!-- Modal -->
                                        @include('users.modal')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <hr class="my-5" />
        @if (session('success'))
            <script type="text/javascript">
                showToast('Success!', '{{ session('success') }}', 'success');
            </script>
        @endif
    </div>
@endsection
