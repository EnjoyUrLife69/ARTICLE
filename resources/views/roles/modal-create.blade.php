<!-- Create Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Add Data
                    roles
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('roles.store') }}" method="post" role="form" enctype="multipart/form-data">
                @csrf
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
                                        aria-describedby="basic-icon-default-fullname2" value="{{ old('name') }}" />
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
                                <div class="input-group input-group-merge">
                                    @foreach ($permission as $key => $value)
                                        <div class="col-md-3">
                                            <label><input class="form-check-input permission-checkbox" type="checkbox"
                                                    name="permission[{{ $value->id }}]" value="{{ $value->id }}"
                                                    class="name" data-group="{{ explode('-', $value->name)[0] }}"
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
