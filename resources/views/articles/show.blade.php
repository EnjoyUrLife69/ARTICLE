{{-- Show Modal --}}
<div class="modal fade" id="Show{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; white-space: normal; word-wrap: break-word; word-break: break-word; max-width: 90%;"
                    class="modal-title" id="Show{{ $data->id }}Title">
                    {{ $data->title }}
                </h5>
                <b
                    class="badge 
                        {{ $data->status == 'approved' ? 'bg-success' : '' }}
                        {{ $data->status == 'pending' ? 'bg-warning' : '' }}
                        {{ $data->status == 'rejected' ? 'bg-danger' : '' }}">
                    <i
                        class="{{ $data->status == 'approved' ? 'bx bx-check-double' : '' }}
                              {{ $data->status == 'pending' ? 'bx bx-time-five' : '' }}
                              {{ $data->status == 'rejected' ? 'bx bxs-message-square-x' : '' }}">
                    </i>
                    {{ ucfirst($data->status) }}
                </b>
            </div>
            <div class="modal-body" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                <center><img src="{{ asset('storage/images/articles/' . $data->cover) }}" alt=""
                        style="max-width: 30rem; box-shadow: 5px 5px 8px rgba(0, 0, 0, 0.3); border-radius: 5px;">
                </center><br>
                <div class="row">
                    <div class="col-9">
                        <b
                            style="color: rgb(108, 94, 14)">{{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}</b>
                    </div>
                    <div class="col-3">
                        <span class="badge bg-primary">{{ $data->categorie->name }}</span>
                    </div>
                </div>
                <div class="mt-3">{!! $data->content !!}</div>
                <!-- Konten lainnya -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Request Modal --}}
<div class="modal fade" id="Show-request{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; white-space: normal; word-wrap: break-word; word-break: break-word; max-width: 100%;"
                    class="modal-title" id="Show{{ $data->id }}Title">
                    {{ $data->title }}
                </h5>
            </div>
            <div class="modal-body" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                <center><img src="{{ asset('storage/images/articles/' . $data->cover) }}" alt=""
                        style="max-width: 30rem; box-shadow: 5px 5px 8px rgba(0, 0, 0, 0.3); border-radius: 5px; ">
                </center><br>
                <div class="row" style="margin-left: -30px">
                    <div class="col-2">
                        <center><img src="{{ asset('storage/images/users/' . $data->user->image) }}"
                                alt="Profile Image" class="img-fluid rounded-circle" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="{{ $data->user->name }}" data-bs-offset="0,4"
                                data-bs-html="true" style="width: 35px; height: 35px"></center>
                    </div>
                    <div class="col-10" style="margin-left: -30px; margin-top: -5px">
                        <div class="row">
                            <div class="col-9">
                                <b>{{ $data->user->name }}</b>
                            </div>
                            <div class="col-3">
                                <span style="margin-left: 20px;"
                                    class="badge bg-primary">{{ $data->categorie->name }}</span>
                            </div>
                            <div class="col-12">
                                <b
                                    style="color: rgb(108, 94, 14)">{{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">{!! $data->content !!}</div>
                <!-- Konten lainnya -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-danger" data-bs-target="#modalToggle2"
                    data-bs-toggle="modal" data-bs-dismiss="modal">Reject</button>
                <form action="{{ route('articles.approve', $data->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                </form>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject --}}
<div class="modal fade" id="modalToggle2" aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel2">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('articles.reject', $data->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')

                <!-- Modal Body -->
                <div class="modal-body">
                    Please provide a <b>Reason</b> for rejecting this article. <br>
                    Your feedback will help the writer understand the issues and improve their content. <br><br>
                    <textarea style="height: 200px" id="basic-default-message" class="form-control" name="review_notes"
                        placeholder="Write your feedback here..." aria-describedby="basic-icon-default-message2"></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <!-- Tombol Cancel -->
                    <button type="button" class="btn btn-sm btn-primary"
                        data-bs-target="#Show-request{{ $data->id }}" data-bs-toggle="modal"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-sm btn-danger">
                        Submit
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>
