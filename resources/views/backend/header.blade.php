<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search"
                    aria-label="Search" />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- Notification -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a id="notification-bell" class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class='bx bx-bell' style="font-size: 24px;"></i>
                    <span class="badge bg-label-primary rounded-pill">
                        {{ $unreadCount > 0 ? $unreadCount : '' }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <!-- Header Notification -->
                    <li class="dropdown-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <span>Notification</span>
                            <span class="badge bg-label-primary">{{ $unreadCount }} New</span>
                            <i class='bx bx-envelope-open ms-2'></i>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <!-- Notification Items -->
                    @forelse ($notifications as $notification)
                        <li>
                            <a class="dropdown-item d-flex align-items-start"
                                href="{{ route('notification.read', $notification->id) }}">
                                <div class="flex-shrink-0 me-3">
                                    -
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $notification->title }}</h6>
                                    <small class="text-muted">{{ Str::limit($notification->message, 50) }}</small>

                                </div>
                                <span
                                    class="badge bg-label-info ms-2">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                    @empty
                        <li>
                            <p class="dropdown-item text-center">Tidak ada notifikasi.</p>
                        </li>
                    @endforelse
                    <!-- View All Notifications -->
                    <li>
                        <a class="dropdown-item text-center text-primary" href="#">
                            <b>View all notifications</b>
                        </a>
                    </li>
                </ul>
            </li>


            {{-- Profile Dropdown --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('storage/images/users/' . $user->image) }}" alt="Profile Image"
                            class="img-fluid rounded-circle" width="100" height="100">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('storage/images/users/' . $user->image) }}"
                                            alt="Profile Image" class="img-fluid rounded-circle" width="100"
                                            height="100">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <!-- Tampilkan nama pengguna yang sedang login -->
                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>

                                    <!-- Tampilkan role pengguna yang sedang login -->
                                    <small class="text-muted">
                                        @foreach (Auth::user()->getRoleNames() as $role)
                                            {{ ucfirst($role) }}
                                        @endforeach
                                    </small>
                                </div>

                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{url('/')}}">
                            <i class="bx bx-arrow-back me-2"></i>
                            <span class="align-middle">Go To Site</span>
                        </a>
                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                <span class="flex-grow-1 align-middle">Billing</span>
                                <span
                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                            </span>
                        </a> --}}
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<!-- / Navbar -->
