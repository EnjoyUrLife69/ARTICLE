@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">Roles & Permission</center>
                    </div>
                </h3>
            </div>
        </div>
        <!-- Bordered Table -->
        <div class="card mt-3">
            <div class="row" style="margin-top: 10px;">
                <div class="col-10">
                    <h5 class="card-header">Add Data Role</h5>
                </div>
                {{-- CREATE DATA --}}
                @can('role-create')
                    <div class="col-2 mt-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                            <i class='bx bx-plus-circle'></i> Add Data
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Add Data
                                        roles
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('roles.store') }}" method="post" role="form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama
                                                    Role</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                                class='bx bx-user'></i></span>
                                                        <input type="text" class="form-control"
                                                            id="basic-icon-default-fullname" placeholder="Enter Name" required
                                                            style="padding-left: 15px;" name="name"
                                                            aria-describedby="basic-icon-default-fullname2"
                                                            value="{{ old('name') }}" />
                                                    </div>
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-icon-default-fullname">Permission</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        @foreach ($permission as $key => $value)
                                                            <div class="col-md-3">
                                                                <label><input class="form-check-input permission-checkbox"
                                                                        type="checkbox" name="permission[{{ $value->id }}]"
                                                                        value="{{ $value->id }}" class="name"
                                                                        data-group="{{ explode('-', $value->name)[0] }}"
                                                                        data-type="{{ explode('-', $value->name)[1] }}">
                                                                    {{ $value->name }}</label>
                                                            </div>
                                                            @if (($key + 1) % 4 == 0)
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th width="100px">
                                    <center>No</center>
                                </th>
                                <th style="width: 80%">Role</th>
                                <th width="280px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>
                                        <center>{{ $no++ }}</center>
                                    </td>
                                    <td><b>{{ $role->name }}</b></td>
                                    <td>
                                        {{-- SHOW DATA --}}
                                        <button type="button" class="btn btn-sm btn-warning"
                                            data-bs-target="#Show{{ $role->id }}" data-bs-toggle="modal">
                                            <i class='bx bx-show-alt' data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Show" data-bs-offset="0,4" data-bs-html="true"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="Show{{ $role->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="EditTitle">
                                                            Show
                                                            Data Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('roles.update', $role->id) }}" method="post"
                                                        role="form" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="row mb-3">
                                                                    <label class="col-sm-2 col-form-label"
                                                                        for="basic-icon-default-fullname">Nama
                                                                        Role</label>
                                                                    <div class="col-sm-10">
                                                                        <div class="input-group input-group-merge">
                                                                            <span id="basic-icon-default-fullname2"
                                                                                class="input-group-text"><i
                                                                                    class='bx bx-user'></i></span>
                                                                            <input type="text" class="form-control"
                                                                                id="basic-icon-default-fullname"
                                                                                placeholder="Enter Name" required disabled
                                                                                style="padding-left: 15px;" name="name"
                                                                                aria-describedby="basic-icon-default-fullname2"
                                                                                value="{{ $role->name }}" />
                                                                        </div>
                                                                        @error('name')
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-sm-2 col-form-label"
                                                                        for="basic-icon-default-fullname">Permission</label>
                                                                    <div class="col-sm-10">
                                                                        <div class="row">
                                                                            @foreach ($permission as $key => $perm)
                                                                                <div class="col-md-3">
                                                                                    <label>
                                                                                        <input
                                                                                            class="form-check-input permission-checkbox"
                                                                                            type="checkbox" disabled
                                                                                            name="permission[{{ $perm->id }}]"
                                                                                            value="{{ $perm->id }}"
                                                                                            {{ in_array($perm->id, $role->permissions) ? 'checked' : '' }}
                                                                                            data-group="{{ explode('-', $perm->name)[0] }}"
                                                                                            data-type="{{ explode('-', $perm->name)[1] }}">
                                                                                        {{ $perm->name }}
                                                                                    </label>
                                                                                </div>

                                                                                {{-- Setiap 4 checkbox, mulai baris baru --}}
                                                                                @if (($key + 1) % 4 == 0)
                                                                        </div>
                                                                        <div class="row">
                            @endif
                            @endforeach
                </div>
            </div>
        </div>

    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    </form>
    </div>
    </div>
    </div>

    {{-- EDIT DATA --}}
    @can('role-edit')
        <button type="button" class="btn btn-sm btn-primary" data-bs-target="#Edit{{ $role->id }}"
            data-bs-toggle="modal">
            <i class='bx bx-edit' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-bs-offset="0,4"
                data-bs-html="true"></i>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="Edit{{ $role->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditTitle">
                            Edit
                            Data Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('roles.update', $role->id) }}" method="post" role="form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama
                                        Role</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class='bx bx-user'></i></span>
                                            <input type="text" class="form-control" id="basic-icon-default-fullname"
                                                placeholder="Enter Name" required style="padding-left: 15px;" name="name"
                                                aria-describedby="basic-icon-default-fullname2"
                                                value="{{ $role->name }}" />
                                        </div>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"
                                        for="basic-icon-default-fullname">Permission</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            @foreach ($permission as $key => $perm)
                                                <div class="col-md-3"> <!-- Biarkan kolom tanpa margin bawah -->
                                                    <label>
                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            name="permission[{{ $perm->id }}]"
                                                            value="{{ $perm->id }}"
                                                            {{ in_array($perm->id, $role->permissions) ? 'checked' : '' }}
                                                            data-group="{{ explode('-', $perm->name)[0] }}"
                                                            data-type="{{ explode('-', $perm->name)[1] }}">
                                                        {{ $perm->name }}
                                                    </label>
                                                </div>

                                                {{-- Setiap 4 checkbox, mulai baris baru dengan jarak antara baris --}}
                                                @if (($key + 1) % 4 == 0)
                                        </div>
                                        <div class="row"> <!-- Baris baru dengan margin bawah -->
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    {{-- DELETE DATA --}}
    @can('role-delete')
        <form id="deleteForm{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST"
            style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger" id="deleteButton{{ $role->id }}"
                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                title="<span>Delete</span>">
                <i class='bx bx-trash'></i>
            </button>
        </form>
    @endcan
    </td>
    </tr>
    @endforeach
    </tbody>

    </table>
    </div>
    </div>
    </div>
    <hr class="my-5" />
    </div>
    @if (session('success'))
        <script type="text/javascript">
            showToast('Success!', '{{ session('success') }}', 'success');
        </script>
    @endif
@endsection
