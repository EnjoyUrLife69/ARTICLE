<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ Auth::user()->role == 'superadmin' ? route('admin.dashboard') : route('writer.dashboard') }}" class="app-brand-link"
            style="display: flex; align-items: center; text-decoration: none; color: #000; font-family: 'Poppins', sans-serif; font-weight: bold; font-size: 1.4rem;">
            <span class="app-brand-logo demo" style="margin-right: 10px; display: flex; align-items: center;">
                <!-- Logo image here -->
                <img src="{{ asset('assets/img/open-book-black.png') }}"
                    style="width: 32px; height: auto; object-fit: contain; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);"
                    class="logo-image" alt="Logo">
            </span>
            <span
                style="font-size: 1.5rem; color: #363e46; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.15);"><em>ARTICLE'S</em></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('writer.dashboard', 'admin.dashboard') ? 'active' : '' }}">
            @if (auth()->user()->hasRole('Super Admin'))
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                @else
                    <a href="{{ route('writer.dashboard') }}" class="menu-link">
            @endif
            <i class="menu-icon tf-icons bx bx-home"></i>
            <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @if (auth()->user()->can('article-list'))
            <li
                class="menu-item {{ request()->routeIs('articles.index') || request()->routeIs('articles.create') || request()->routeIs('articles.edit') ? 'active' : '' }}">
                <a href="{{ route('articles.index') }}"
                    class="menu-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class="menu-icon tf-icons bx bxs-book-content"></i>
                        <span data-i18n="Analytics">Article</span>
                    </div>
                </a>
            </li>
        @endif
        <li class="menu-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
            <a href="{{ route('notifications.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Analytics">Notification</div>
            </a>
        </li>

        @if (auth()->user()->hasRole('Writer'))
            <li class="menu-item {{ request()->routeIs('earning.index') ? 'active' : '' }}">
                <a href="{{ route('earning.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-dollar-circle'></i>
                    <div data-i18n="Analytics">Earn</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('withdraw.index') ? 'active' : '' }}">
                <a href="{{ route('withdraw.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-dollar-circle'></i>
                    <div data-i18n="Analytics">Withdraw</div>
                </a>
            </li>
        @endif

        <li class="menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <a href="{{ route('profile') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Profile</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('/') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-arrow-back"></i>
                <div data-i18n="Analytics">Go to Site</div>
            </a>
        </li>


        {{-- <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Categories</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">Without navbar</div>
                    </a>
                </li>
            </ul>
        </li> --}}

        @if (auth()->user()->can('user-list') && auth()->user()->can('role-list') && auth()->user()->can('categorie-list'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">( Super Admin Only )</span>
            </li>

            <li class="menu-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Analytics">Categories</div>
                </a>
            </li>
            {{-- <li class="menu-item {{ request()->routeIs('articles.all') ? 'active' : '' }}">
                <a href="{{ route('articles.all') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-unite"></i>
                    <div data-i18n="Analytics">All Articles</div>
                </a>
            </li> --}}
            <li class="menu-item {{ request()->routeIs('request') ? 'active' : '' }}">
                <a href="{{ route('request') }}" class="menu-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class='menu-icon tf-icons bx bx-git-pull-request'></i>
                        <span data-i18n="Analytics">Article Request</span>
                    </div>
                    @if ($newArticlesCount > 0)
                        <span
                            class="badge bg-danger ms-auto">{{ isset($newArticlesCount) ? $newArticlesCount : 'Data tidak tersedia' }}
                        </span>
                    @endif
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.pending-writers') ? 'active' : '' }}">
                <a href="{{ route('admin.pending-writers') }}"
                    class="menu-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class='menu-icon tf-icons bx bx-user-plus'></i>
                        <span data-i18n="Analytics">Writer Request</span>
                    </div>
                    @if ($pendingWritersCount > 0)
                        <span class="badge bg-danger ms-auto">
                            {{ $pendingWritersCount ?? '0' }}
                        </span>
                    @endif
                </a>
            </li>



            <li
                class="menu-item {{ request()->routeIs('users.index') || request()->routeIs('roles.index') ? 'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                    <div data-i18n="Account Settings">Access Control List</div>
                </a>
                <ul class="menu-sub {{ request()->routeIs('users.index') || request()->routeIs('roles.index') ? 'show' : '' }}"
                    style="display: block;">
                    <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="menu-link">
                            <div data-i18n="Account">Role & Permission</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div data-i18n="Account">User</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
