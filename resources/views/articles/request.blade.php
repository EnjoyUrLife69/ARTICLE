@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bx-git-pull-request' style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Articles Request </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>
        @if (session('success'))
            <script type="text/javascript">
                showToast('Success!', '{{ session('success') }}', 'success');
            </script>
        @endif
        <div class="card mt-4">
            <div class="card-body">
                @if(count($articles) > 0)
                <div class="table-responsive text-nowrap">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr style="font-weight: bold">
                                <th>No</th>
                                <th>Writer</th>
                                <th>Title</th>
                                <th>Release Date</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($articles as $data)
                                <tr>
                                    <td style="font-weight: bold">{{ $loop->iteration }}</td>
                                    <td style="font-weight: bold"><center><img src="{{ asset('storage/images/users/' . $data->user->image) }}"
                                            alt="Profile Image" class="img-fluid rounded-circle" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ $data->user->name }}" data-bs-offset="0,4" data-bs-html="true"
                                            style="width: 35px; height: 35px"></center></td>
                                    <td style="font-weight: bold">{{ Str::limit($data->title, 45) }}</td>
                                    <td style="font-weight: bold">{{ $data->categorie->name }}</td>
                                    <td style="font-weight: bold">
                                        {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D ,jS M Y') }}
                                    </td>
                                    <td><b
                                            class="badge 
                                    {{ $data->status == 'pending' ? 'bg-warning' : '' }}"><i
                                                class='bx bx-time-five'></i>
                                            {{ ucfirst($data->status) }} </b>
                                    </td>
                                    <td>
                                        {{-- SHOW --}}
                                        <button type="button" class="btn btn-sm btn-warning"
                                            data-bs-target="#Show-request{{ $data->id }}" data-bs-toggle="modal">
                                            <i class='bx bx-show-alt' data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Show" data-bs-offset="0,4" data-bs-html="true"></i>
                                        </button>
                                        @include('articles.show')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <!-- Empty State with Simple Animation -->
                <div class="empty-state-container text-center py-5">
                    <div class="empty-state-icon mb-4">
                        <i class='bx bx-file-find bx-tada' style="font-size: 100px; color: #d6dbf5;"></i>
                    </div>
                    <h4 class="text-primary" style="color: #696cff !important; font-weight: 600;">No Article Requests Found</h4>
                    <p class="text-muted mt-2 mb-4">
                        There are currently no pending article requests to review.
                    </p>
                    <button type="button" class="btn btn-primary mt-2" onclick="refreshPage()">
                        <i class='bx bx-refresh me-1'></i> Refresh
                    </button>
                </div>
                
                <!-- Fallback CSS Animation -->
                <style>
                    .empty-state-container {
                        padding: 40px 20px;
                    }
                    
                    .empty-state-icon {
                        animation: pulse 2s infinite;
                    }
                    
                    @keyframes pulse {
                        0% {
                            transform: scale(1);
                        }
                        50% {
                            transform: scale(1.1);
                        }
                        100% {
                            transform: scale(1);
                        }
                    }
                    
                    .bx-tada {
                        animation: tada 1.5s ease infinite;
                    }
                    
                    @keyframes tada {
                        0% {
                            transform: scale(1) rotate(0);
                        }
                        10%, 20% {
                            transform: scale(0.9) rotate(-3deg);
                        }
                        30%, 50%, 70%, 90% {
                            transform: scale(1.1) rotate(3deg);
                        }
                        40%, 60%, 80% {
                            transform: scale(1.1) rotate(-3deg);
                        }
                        100% {
                            transform: scale(1) rotate(0);
                        }
                    }
                </style>
                @endif
            </div>
        </div>
    </div>

    <script>
        function refreshPage() {
            window.location.reload();
        }
    </script>
@endsection