<!-- MODALS EDIT -->
<div class="modal fade" id="Edit{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditTitle">
                    Edit
                    Data Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="post" role="form"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Username</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class='bx bx-user'></i></span>
                                <input style="font-weight: bold; padding-left: 15px;" type="text" id="nameWithTitle" disabled
                                    required class="form-control" name="name" value="{{ $user->name }}" />
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Email</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class='bx bx-envelope'></i></span>
                                <input style="font-weight: bold; padding-left: 15px;" type="text" id="nameWithTitle" disabled
                                    required class="form-control" name="email" value="{{ $user->email }}" />
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Role</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class='bx bx-category'></i></span>
                                <select id="defaultSelect2" class="form-select" name="roles[]">
                                    @foreach ($roles as $value => $label)
                                        <option value="{{ $value }}"
                                            @if (in_array($value, $user->userRole)) selected @endif>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('roles')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Photo Profile</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class='bx bx-category'></i></span>
                                <input class="form-control" type="file" id="formFile" name="image"
                                    accept="image/*" onchange="previewImage(); displayFileName();"
                                    {{ !$user->image ? 'required' : '' }} />
                            </div>
                        </div>
                    </div> --}}
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

<!-- MODALS SHOW -->
<div class="modal fade" id="Show{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="role" style="position: relative;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 0; right: 0;"></button>
            </div>
            <div class="modal-header"
                style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;">
                <img style="margin-left: 2%;" src="{{ asset('storage/images/users/' . $user->image) }}"
                    alt="Profile Image" class="img-fluid rounded-circle" width="150" height="150">
            </div>
            <div class="row mt-1">
                <center>
                    <h3><b>{{ $user->name }}</b></h3>
                    <h6 class="text-muted">{{ $user->email }}</h6>
                </center>
            </div>
            <div class="row mt-1">
                <center>

                </center>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                            <div class="row mt-3">
                                <center>
                                    <h6 style="font-weight: bold;">ARTICLE POSTED</h6>
                                </center>
                            </div>
                            <div class="row">
                                <center>
                                    <p><b style="color: red;">{{ $user->article->count() }}</b> Article</p>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card" style="box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);">
                            <div class="row mt-3">
                                <center>
                                    <h6 style="font-weight: bold;">ARTICLE APPROVED</h6>
                                </center>
                            </div>
                            <div class="row">
                                <center>
                                    <p><b style="color: green;">{{ $user->article()->status('approved')->count() }}</b>  Article</p>
                                </center>
                            </div>
                        </div>
                    </div>
                </div><br>
                <b><em>{{ $user->name }}'s Article</em></b>
                @if ($user->article->isNotEmpty())
                    @foreach ($user->article->take(3) as $data)
                        <div class="row">
                            <div class="col-sm-1">
                                <hr>
                                <center>{{ $loop->iteration }}</center>
                            </div>
                            <div class="col-sm-9">
                                <hr> {{ $data->title }} 
                            </div>
                            <div class="col-sm-2">
                                <hr> {{ \Carbon\Carbon::parse($data->release_date)->format('d/m/Y') }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <hr><em>This user has not written any articles yet.</em>
                        </div>
                    </div>
                @endif

                <hr>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save
                    changes</button>
            </div> --}}
        </div>

    </div>
</div>
</div>
