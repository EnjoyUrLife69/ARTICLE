<!-- Modal -->
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Add Data
                                            User
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.store') }}" method="post" role="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-icon-default-fullname">Username<b style="color: red">
                                                            *</b></label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2"
                                                                class="input-group-text"><i
                                                                    class='bx bx-category'></i></span>
                                                            <input type="text" class="form-control"
                                                                value="{{ old('name') }}" id="basic-icon-default-fullname"
                                                                placeholder="Enter Name" required aria-label="John Doe"
                                                                name="name"
                                                                aria-describedby="basic-icon-default-fullname2" />
                                                        </div>
                                                        @error('username')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-icon-default-fullname">Email<b style="color: red">
                                                            *</b></label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2"
                                                                class="input-group-text"><i
                                                                    class='bx bx-category'></i></span>
                                                            <input type="email" class="form-control"
                                                                id="basic-icon-default-fullname" value="{{ old('email') }}"
                                                                placeholder="Enter Email" required aria-label="John Doe"
                                                                name="email"
                                                                aria-describedby="basic-icon-default-fullname2" />
                                                        </div>
                                                        @error('email')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-icon-default-fullname">Password<b style="color: red">
                                                            *</b></label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2"
                                                                class="input-group-text"><i
                                                                    class='bx bx-category'></i></span>
                                                            <input type="password" class="form-control"
                                                                value="{{ old('password') }}"
                                                                id="basic-icon-default-fullname" placeholder="Password"
                                                                required aria-label="John Doe" name="password"
                                                                aria-describedby="basic-icon-default-fullname2" />
                                                        </div>
                                                        @error('password')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-icon-default-fullname">Confirm<b style="color: red">
                                                            *</b> Password</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2"
                                                                class="input-group-text"><i
                                                                    class='bx bx-category'></i></span>
                                                            <input type="password" class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                placeholder="Confirm password" required
                                                                aria-label="John Doe" name="confirm-password"
                                                                aria-describedby="basic-icon-default-fullname2" />
                                                        </div>
                                                        @error('confirm-password')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="row mb-3">
                                                    <label for="defaultSelect"
                                                        class="col-sm-2 col-form-label">Role</label>
                                                    <div class="col-sm-10">
                                                        <select id="defaultSelect" class="form-select" name="roles[]">
                                                            <option value="" disabled selected>Select Role</option>
                                                            @foreach ($roles as $value => $label)
                                                                <option value="{{ $value }}">{{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('roles')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                                                <div class="row mb-3">
                                                    <label for="defaultSelect"
                                                        class="col-sm-2 col-form-label">Role</label>
                                                    <div class="col-sm-10">
                                                        <select id="defaultSelect1" class="form-select" name="roles[]">
                                                            <option value="" disabled selected>Select Role</option>
                                                            @foreach ($roles as $value => $label)
                                                                <option value="{{ $value }}">{{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('roles')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>