<h1 class="site-title">ARTICLE'S</h1>
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <div class="datetime">
                <i class="far fa-calendar-alt"></i>
                <b><span id="date"></span></b>
            </div>
        </div>
        <button class="menu-button" onclick="toggleMenu(this)">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">HOME</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link">CATEGORY</a>
                <div class="dropdown-content">
                    @foreach ($categories as $cat)
                        <a href="{{ url('/category/' . $cat->id) }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ url('/category/' . $categories->firstWhere('name', 'Lifestyle')?->id) }}"
                    class="nav-link">LIFESTYLE</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/category/' . $categories->firstWhere('name', 'Science')?->id) }}"
                    class="nav-link">SCIENCE</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/category/' . $categories->firstWhere('name', 'Entertainment')?->id) }}"
                    class="nav-link">ENTERTAINMENT</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/category/' . $categories->firstWhere('name', 'Music')?->id) }}"
                    class="nav-link">MUSIC</a>
            </li> --}}

            <li class="nav-item dropdown">
                <a href="#" class="nav-link">MORE</a>
                <div class="dropdown-vertical">
                    <a href="#"><i class="fas fa-heart"></i>LOREM IPSUM</a>
                    <a href="#"><i class="fas fa-plane"></i>LOREM IPSUM</a>
                    <a href="#"><i class="fas fa-briefcase"></i>LOREM IPSUM</a>
                </div>
            </li>
        </ul>
        <!-- Perubahan di bagian nav-icons dalam navbar -->
        <div class="nav-icons">
            <i class="fas fa-search nav-icon search-toggle"></i>

            <!-- Search Overlay -->
            <div class="search-wrapper">
                <button class="search-close">
                    <i class="fas fa-times"></i>
                </button>
                <form action="{{ route('articles.search') }}" method="GET" class="search-form">
                    <input type="text" name="query" class="search-input" placeholder="Search ..."
                        autocomplete="off">
                    <button type="submit" class="search-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Ubah dari dropdown menjadi profile modal trigger -->
            <div class="profile-modal-trigger">
                <i class="fas fa-user nav-icon"></i>
            </div>
        </div>
    </div>
</nav>

<div class="profile-modal">
    <div class="profile-modal-content">
        <div class="profile-modal-header">
            <h3>Menu</h3>
            <button class="profile-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="profile-modal-body">
            @if (Auth::check())
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="{{ Auth::user()->image_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle"
                            width="60" height="60" style="object-fit: cover; border: 2px solid #ccc; ">
                    </div>
                    <div class="user-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                </div>

                @if (Auth::user()->hasRole('Pending Writer'))
                    <div class="alert alert-warning mt-2"
                        style="font-size: 14px; padding: 8px; border-radius: 6px; background-color: #fff3cd; color: #856404;">
                        <i class="fas fa-hourglass-half me-1"></i> Waiting for admin approval to become a writer.
                    </div>
                @endif
                @if (Auth::user()->hasRole('Writer'))
                    <div class="alert alert-success mt-2"
                        style="font-size: 14px; padding: 8px; border-radius: 6px; background-color: #d4edda; color: #155724;">
                        <i class="fas fa-pen-nib me-1"></i> You are now a Writer! You can create articles in your
                        dashboard.
                    </div>
                @endif
                @if (Auth::user()->hasRole('Rejected Writer'))
                    <div class="alert alert-danger mt-2"
                        style="font-size: 14px; padding: 8px; border-radius: 6px; background-color: #f8d7da; color: #721c24;">
                        <i class="fas fa-times-circle me-1"></i>
                        Your writer application has been rejected.
                    </div>
                @endif

                <div class="modal-menu-items">
                    @if (Auth::user()->hasRole('Writer'))
                        <a href="{{ route('writer.dashboard') }}" class="modal-menu-item">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>DASHBOARD</span>
                        </a>
                    @endif
                    <a href="{{ route('profile') }}" class="modal-menu-item">
                        <i class="fas fa-user"></i>
                        <span>PROFILE</span>
                    </a>
                    <a href="{{ route('logout') }}" class="modal-menu-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>LOGOUT</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @else
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <h4>Guest</h4>
                        <p>Sign in to access all features</p>
                    </div>
                </div>
                <div class="modal-menu-items">
                    <a href="{{ route('login') }}" class="modal-menu-item">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>LOGIN</span>
                    </a>
                    <a href="{{ route('register') }}" class="modal-menu-item">
                        <i class="fas fa-user-plus"></i>
                        <span>REGISTER</span>
                    </a>
                </div>
            @endif
            {{-- <div class="modal-menu-items">
                <a href="#" class="modal-menu-item">
                    <i class="fas fa-heart"></i>
                    <span>FAVORITES</span>
                </a>
                <a href="#" class="modal-menu-item">
                    <i class="fas fa-bookmark"></i>
                    <span>BOOKMARKS</span>
                </a>
                <a href="#" class="modal-menu-item">
                    <i class="fas fa-cog"></i>
                    <span>SETTINGS</span>
                </a>
            </div> --}}
            {{-- <div class="modal-menu-items">
                <a href="#" class="modal-menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span>HELP & SUPPORT</span>
                </a>
                <a href="#" class="modal-menu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>ABOUT US</span>
                </a>
            </div> --}}
        </div>
        <div class="modal-footer">
            &copy; 2025 ARTICLE'S - All Rights Reserved
        </div>
    </div>
    <div class="profile-modal-backdrop"></div>
</div>

<!-- Script untuk modal profile -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileTrigger = document.querySelector('.profile-modal-trigger');
        const profileModal = document.querySelector('.profile-modal');
        const profileClose = document.querySelector('.profile-modal-close');
        const profileBackdrop = document.querySelector('.profile-modal-backdrop');

        // Mengukur lebar scrollbar sebelum menonaktifkan scroll
        const getScrollbarWidth = () => {
            return window.innerWidth - document.documentElement.clientWidth;
        };

        // Buka modal
        profileTrigger.addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah event klik menyebar

            // Simpan posisi scroll saat ini
            const scrollY = window.scrollY;

            // Menerapkan padding-right sebesar lebar scrollbar untuk mencegah layout shift
            const scrollbarWidth = getScrollbarWidth();
            document.body.style.paddingRight = scrollbarWidth + 'px';

            // Mengunci scroll dengan mempertahankan posisi
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = '100%';
            document.body.style.overflow = 'hidden';

            // Aktifkan modal dengan sedikit delay untuk animasi yang lebih smooth
            requestAnimationFrame(() => {
                profileModal.classList.add('active');
            });
        });

        // Fungsi untuk menutup modal
        const closeModal = () => {
            // Hapus kelas aktif
            profileModal.classList.remove('active');

            // Mengembalikan scroll dengan posisi yang sama
            const scrollY = parseInt(document.body.style.top || '0') * -1;
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.paddingRight = '';
            document.body.style.width = '';
            document.body.style.overflow = '';

            // Kembalikan posisi scroll
            window.scrollTo(0, scrollY);
        };

        // Tutup modal dengan tombol close
        profileClose.addEventListener('click', function(e) {
            e.stopPropagation();
            closeModal();
        });

        // Tutup modal dengan klik di backdrop
        profileBackdrop.addEventListener('click', function(e) {
            e.stopPropagation();
            closeModal();
        });

        // Hentikan propagasi klik di dalam konten modal
        const modalContent = document.querySelector('.profile-modal-content');
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah klik di konten menutup modal
        });

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && profileModal.classList.contains('active')) {
                closeModal();
            }
        });
    });
</script>

<script>
    // Add sticky class on scroll
    window.onscroll = function() {
        const navbar = document.querySelector('.navbar');
        const title = document.querySelector('.site-title');
        const titleBottom = title.offsetTop + title.offsetHeight;

        if (window.pageYOffset >= titleBottom) {
            navbar.classList.add('sticky');
        } else {
            navbar.classList.remove('sticky');
        }
    };

    // Toggle mobile menu with animation
    function toggleMenu(button) {
        const menu = document.querySelector('.nav-menu');
        button.classList.toggle('active');
        menu.classList.toggle('active');
    }

    // Handle dropdown on mobile
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        if (window.innerWidth <= 768) {
            dropdown.querySelector('.nav-link').addEventListener('click', (e) => {
                e.preventDefault();
                dropdown.classList.toggle('active');
            });
        }
    });

    // Update date and time
    function updateDateTime() {
        const now = new Date();

        // Format date: Tuesday, February 18, 2024
        const dateOptions = {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
        };
        const dateStr = now.toLocaleDateString('en-US', dateOptions);

        // Format time: 14:30:45
        const timeStr = now.toLocaleTimeString('en-US', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        document.getElementById('date').textContent = dateStr;
    }

    // Update immediately and then every second
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

<script>
    document.querySelector('.user-dropdown').addEventListener('click', function(e) {
        this.classList.toggle('active');
        e.stopPropagation();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-dropdown')) {
            document.querySelector('.user-dropdown').classList.remove('active');
        }
    });
</script>

<script>
    // Search Toggle
    // Simplified Search Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchWrapper = document.querySelector('.search-wrapper');
        const searchClose = document.querySelector('.search-close');
        const searchInput = document.querySelector('.search-input');
        const searchForm = document.querySelector('.search-form');

        // Buka search overlay
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            searchWrapper.classList.add('active');
            setTimeout(() => {
                searchInput.focus();
            }, 300);
        });

        // Tutup search overlay
        searchClose.addEventListener('click', function() {
            searchWrapper.classList.remove('active');
        });

        // Tutup search overlay saat Esc ditekan
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchWrapper.classList.contains('active')) {
                searchWrapper.classList.remove('active');
            }
        });

        // Hindari overlay tertutup saat mengklik di dalam form
        searchWrapper.addEventListener('click', function(e) {
            if (e.target === searchWrapper) {
                searchWrapper.classList.remove('active');
            }
        });

        // Pastikan form pencarian berfungsi dengan benar
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                // Tambahkan parameter untuk mencari hanya di judul dan kategori
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'search_in';
                hiddenInput.value = 'title_category';
                searchForm.appendChild(hiddenInput);
            });
        }
    });
</script>
