@extends('layouts.dashboard')

@section('content')
    @if (session('success'))
        <script type="text/javascript">
            showToast('Success!', '{{ session('success') }}', 'success');
        </script>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bxs-bell' style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Notification </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>
        <div class="col-md mt-4 mb-4 mb-md-0">
            <div class="row">
                <div class="col-9">
                    <small class="text-light fw-semibold">Dashboard / Notifications</small>
                </div>
                <div class="col-3 d-flex justify-content-end">
                    <form action="{{ route('notifications.clear') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary">Clear all Notifications</button>
                    </form>

                </div>
            </div>
            <div class="accordion mt-3 accordion-without-arrow" id="accordionExample">
                @foreach ($notifications as $index => $data)
                    <div class="card accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button type="button" class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                data-bs-toggle="collapse" data-bs-target="#accordion{{ $index }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="accordion{{ $index }}">
                                <b>
                                    {!! str_replace(
                                        ['Approved', 'Rejected', 'Your Article titled', 'has been'],
                                        [
                                            "<span style='color: green;'>Approved</span>",
                                            "<span style='color: red;'>Rejected</span>",
                                            "<span style='font-weight: normal;'>Your Article titled</span>",
                                            "<span style='font-weight: normal;'>has been</span>",
                                        ],
                                        $data->message,
                                    ) !!}
                                </b>
                            </button>
                        </h2>

                        <div id="accordion{{ $index }}"
                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                </p>
                                @if ($data->review_notes)
                                    <p><strong>Admin Feedback:</strong></p>
                                    <p>{{ $data->review_notes }}</p>
                                @else
                                    <span>
                                        <center><em>Article Approved. No review notes provided.</em></center>
                                    </span>
                                @endif
                                <p class="text-end"><strong>Date : </strong>
                                    {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}

                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($notifications->isEmpty())
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class='bx bxs-bell-off'
                                    style="font-size: 50px; color: #888; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                                <h5 class="mt-3" style="color: #888;">No Notifications</h5>
                                <p class="text-muted">You have no notifications at the moment. Check back later for updates!
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
