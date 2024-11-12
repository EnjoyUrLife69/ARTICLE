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
                    <i class='bx bx-time-five'></i> {{ ucfirst($data->status) }} </b>
            </div>
            <div class="modal-body" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                <center><img src="{{ asset('storage/images/articles/' . $data->cover) }}" alt=""
                        style="max-width: 30rem"></center><br>
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

<div class="modal fade" id="Show-request{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; white-space: normal; word-wrap: break-word; word-break: break-word; max-width: 100%;"
                    class="modal-title" id="Show{{ $data->id }}Title">
                    {{ $data->title }}
                </h5>
                <b
                    class="badge
                                            {{ $data->status == 'approved' ? 'bg-success' : '' }}
                                            {{ $data->status == 'pending' ? 'bg-warning' : '' }}
                                            {{ $data->status == 'rejected' ? 'bg-danger' : '' }}">
                    <i class='bx bx-time-five'></i> {{ ucfirst($data->status) }} </b>
            </div>
            <div class="modal-body" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                <center><img src="{{ asset('storage/images/articles/' . $data->cover) }}" alt=""
                        style="max-width: 30rem"></center><br>
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
                <form action="{{ route('articles.reject', $data->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                </form>

                <form action="{{ route('articles.approve', $data->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                </form>

                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
