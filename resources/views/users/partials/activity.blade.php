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
                        <img class="ms-4" src="{{ asset('storage/images/articles/' . $data->img) }}" width="103"
                            alt="img" style="border: 2px solid #E4E6E8; border-radius: 4px;">
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
    <div id="loading-indicator" style="display: none; text-align: center;">
        <p>Loading...</p>
    </div>
    <div class="mt-3">
        {{ $activities->links('pagination::bootstrap-5') }}
    </div>
@endif
