```blade
@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">
                        <i class='bx bx-user-check text-primary me-2'></i> Writer Applications
                    </h4>
                    <p class="text-muted mb-0">Review and manage writer applications</p>
                </div>
                <div>
                    <span class="badge bg-primary rounded-pill">
                        {{ $pendingWriters->count() }} Pending
                    </span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class='bx bx-check-circle me-1'></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($pendingWriters->isEmpty())
            <!-- Empty State Card -->
            <div class="card shadow-none bg-transparent border">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class='bx bx-user-voice text-primary' style="font-size: 80px; opacity: 0.5;"></i>
                    </div>
                    <h4 class="text-primary">No Writer Applications Found</h4>
                    <p class="text-muted mb-4">There are currently no users requesting to become writers.</p>
                    <button class="btn btn-primary" onclick="location.reload()">
                        <i class='bx bx-refresh me-1'></i> Refresh
                    </button>
                </div>
            </div>
        @else
            <!-- Writer Applications -->
            <div class="row">
                @foreach ($pendingWriters as $index => $user)
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-semibold">{{ $user->name }}</h5>
                                <span class="badge bg-label-info">
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="card-body">
                                <!-- User Email -->
                                <div class="d-flex align-items-center mb-3">
                                    <i class='bx bx-envelope text-muted me-2'></i>
                                    <span>{{ $user->email }}</span>
                                </div>

                                <!-- Writer Info Tabs -->
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#bio-{{ $user->id }}" type="button" role="tab">
                                            Bio
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#work-{{ $user->id }}" type="button" role="tab">
                                            Work
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#motivation-{{ $user->id }}" type="button" role="tab">
                                            Motivation
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content p-0 pt-3">
                                    <!-- Bio Tab -->
                                    <div class="tab-pane fade show active" id="bio-{{ $user->id }}" role="tabpanel">
                                        <div class="writer-content">
                                            @if ($user->writerProfile && $user->writerProfile->bio)
                                                {{ $user->writerProfile->bio }}
                                            @else
                                                <span class="text-muted fst-italic">No information provided</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Work Tab -->
                                    <div class="tab-pane fade" id="work-{{ $user->id }}" role="tabpanel">
                                        <div class="writer-content">
                                            @if ($user->writerProfile && $user->writerProfile->previous_work)
                                                <a href="{{ $user->writerProfile->previous_work }}" target="_blank"
                                                    class="d-block">
                                                    <i class='bx bx-link-external me-1'></i> View Previous Work
                                                </a>
                                                <small class="text-muted d-block mt-2 text-truncate">
                                                    {{ $user->writerProfile->previous_work }}
                                                </small>
                                            @else
                                                <span class="text-muted fst-italic">No previous work specified</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Motivation Tab -->
                                    <div class="tab-pane fade" id="motivation-{{ $user->id }}" role="tabpanel">
                                        <div class="writer-content">
                                            @if ($user->writerProfile && $user->writerProfile->motivation)
                                                {{ $user->writerProfile->motivation }}
                                            @else
                                                <span class="text-muted fst-italic">No motivation provided</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-light">
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.approve-writer', $user->id) }}" method="POST"
                                        class="w-100">
                                        @csrf
                                        <input type="hidden" name="name" value="{{ $user->name }}" />
                                        <!-- Hidden input for user name -->
                                        <button type="submit" class="btn btn-success w-100 approve-btn">
                                            <i class="fas fa-check-circle me-1"></i> Approve
                                        </button>
                                    </form>

                                    <button type="submit" class="btn btn-danger w-100" style="height: 39px;"
                                        onclick="rejectWriter({{ $user->id }}, '{{ $user->name }}')">
                                        <i class="fas fa-check-circle me-1"></i> Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Rejection Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-semibold text-dark">Reject Application</h5>
                </div>
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    <div class="modal-body px-4 py-4">
                        <div class="text-center mb-4">
                            <div class="rejection-icon-wrapper mb-3">
                                <i class="bx bx-x-circle text-danger"></i>
                            </div>
                            <p class="mb-0">You are about to reject <span id="writerName" class="fw-bold"></span>'s
                                application</p>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-danger flex-grow-1">
                                Confirm Rejection
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Writer content box */
        .writer-content {
            min-height: 120px;
            max-height: 120px;
            overflow-y: auto;
            padding: 0.5rem;
            background-color: #f9f9f9;
            border-radius: 0.25rem;
            border: 1px solid #eee;
        }

        /* Custom scrollbar for text overflow areas */
        .writer-content {
            scrollbar-width: thin;
            scrollbar-color: #d1d1d1 #f1f1f1;
        }

        .writer-content::-webkit-scrollbar {
            width: 6px;
        }

        .writer-content::-webkit-scrollbar-thumb {
            background-color: #d1d1d1;
            border-radius: 3px;
        }

        .writer-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Card hover effect */
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        /* .card:hover {
                                            transform: translateY(-5px);
                                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                                        } */

        /* Tab styling */
        .nav-tabs .nav-link {
            font-size: 0.85rem;
            padding: 0.5rem;
        }

        /* Badge styling */
        .badge.bg-label-info {
            background-color: rgba(3, 195, 236, 0.1) !important;
            color: #03c3ec !important;
        }

        /* Minimalist Aesthetic Modal Styling */
        #rejectModal .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }

        #rejectModal .modal-header {
            padding-top: 24px;
            padding-left: 24px;
            padding-right: 24px;
        }

        #rejectModal .rejection-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: rgba(234, 84, 85, 0.1);
        }

        #rejectModal .rejection-icon-wrapper i {
            font-size: 32px;
        }

        #rejectModal textarea.form-control {
            border-color: #e9ecef;
            padding: 12px;
            font-size: 14px;
            border-radius: 8px;
            resize: none;
            transition: all 0.2s ease;
        }

        #rejectModal textarea.form-control:focus {
            border-color: #ccc;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }

        #rejectModal .form-text {
            font-size: 12px;
            color: #999;
        }

        #rejectModal .btn {
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        #rejectModal .btn-outline-secondary {
            border-color: #e0e0e0;
            color: #666;
        }

        #rejectModal .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #444;
        }

        #rejectModal .btn-danger {
            background-color: #ea5455;
            border-color: #ea5455;
        }

        #rejectModal .btn-danger:hover {
            background-color: #d64041;
            border-color: #d64041;
        }
    </style>

    <script>
        function rejectWriter(userId, userName) {
            document.getElementById('writerName').textContent = userName;
            document.getElementById('rejectForm').action = `{{ route('admin.reject-writer', ':userId') }}`.replace(
                ':userId', userId);

            // Open rejection modal
            var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }
    </script>

    <script>
        // Add event listener to all 'Approve' buttons
        document.querySelectorAll('.approve-btn').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the form from submitting immediately

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Approve ' + button.closest('form').querySelector('input[name="name"]')
                        .value + ' as a Writer?', // Display user name in the confirmation message
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, approve!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit(); // If confirmed, submit the form
                    }
                });
            });
        });
    </script>
@endsection
