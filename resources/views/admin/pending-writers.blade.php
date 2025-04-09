@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-3">
            <div class="card-body text-center">
                <h3 class="fw-bold" data-aos="fade-down">
                    <i class='bx bx-user-check'></i> Writer Requests
                </h3>
            </div>
        </div>

        @if (session('success'))
            <script>
                showToast('Success!', '{{ session('success') }}', 'success');
            </script>
        @endif

        <div class="card">
            <div class="card-body">
                @if($pendingWriters->isEmpty())
                    <div class="empty-state-container text-center py-5">
                        <i class='bx bx-user-voice bx-tada' style="font-size: 80px; color: #d6dbf5;"></i>
                        <h4 class="text-primary mt-3">No Writer Requests Found</h4>
                        <p class="text-muted">There are currently no users requesting to become writers.</p>
                        <button class="btn btn-primary mt-2" onclick="location.reload()">
                            <i class='bx bx-refresh me-1'></i> Refresh
                        </button>
                    </div>
                @else
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead class="fw-bold">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingWriters as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <form action="{{ route('admin.approve-writer', $user->id) }}" method="POST" onsubmit="return confirm('Approve {{ $user->name }} as Writer?')">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check-circle me-1"></i> Approve
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Optional CSS for empty state --}}
    <style>
        .empty-state-container i {
            animation: tada 1.5s ease infinite;
        }

        @keyframes tada {
            0% { transform: scale(1); }
            10%, 20% { transform: scale(0.9) rotate(-3deg); }
            30%, 50%, 70%, 90% { transform: scale(1.1) rotate(3deg); }
            40%, 60%, 80% { transform: scale(1.1) rotate(-3deg); }
            100% { transform: scale(1) rotate(0); }
        }
    </style>
@endsection
