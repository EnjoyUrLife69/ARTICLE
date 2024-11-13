<!-- Edit Modal -->
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
                                Role <span style="color: red;">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Enter Name" required style="padding-left: 15px;" name="name"
                                        aria-describedby="basic-icon-default-fullname2" value="{{ $role->name }}" />
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Permission <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-10">
                                <div class="row">
                                    @foreach ($permission as $key => $perm)
                                        <div class="col-md-3"> <!-- Biarkan kolom tanpa margin bawah -->
                                            <label>
                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                    name="permission[{{ $perm->id }}]" value="{{ $perm->id }}"
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

<!-- Show Modal -->
<div class="modal fade" id="Show{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditTitle">
                    Show
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
                                Role <span style="color: red;">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Enter Name" required disabled style="padding-left: 15px;"
                                        name="name" aria-describedby="basic-icon-default-fullname2"
                                        value="{{ $role->name }}" />
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Permission <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-10">
                                <div class="row">
                                    @foreach ($permission as $key => $perm)
                                        <div class="col-md-3">
                                            <label>
                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                    disabled name="permission[{{ $perm->id }}]"
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
