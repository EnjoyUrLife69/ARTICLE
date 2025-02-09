<div class="header-area">
    <div class="main-header ">
        <div class="header-top black-bg d-none d-md-block">
            <div class="container">
                <div class="col-xl-12">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="header-info-left">
                            <ul>
                                {{-- <li><img src="{{ asset('assets-front/img/icon/header_icon1.png') }}"
                                        alt="">{{ now()->format('d') }}ºC,
                                    Sunny </li> --}}
                                <li><img src="{{ asset('assets-front/img/icon/header_icon1.png') }}"
                                        alt="">{{ now()->format('l, jS F, Y') }}</li>
                            </ul>

                        </div>
                        <div class="header-info-right">
                            <ul class="header-social">
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li> <a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                        <!-- sticky -->
                        <div class="sticky-logo">
                            <a href="index.html"><img src="#" alt="Logo"></a>
                        </div>
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-md-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="categori.html">Category</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="latest_news.html">Latest News</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="#">Pages</a>
                                        <ul class="submenu">
                                            <li><a href="elements.html">Element</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single-blog.html">Blog Details</a></li>
                                            <li><a href="details.html">Categori Details</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4">
                        <div class="header-right-btn f-right d-none d-lg-block">
                            @auth
                                <!-- Jika user sedang login -->
                                <div class="dropdown">
                                    <img src="{{ asset('storage/images/users/' . Auth::user()->image) }}" alt="User Image"
                                        height="40" width="40" style="border-radius: 50%; cursor: pointer;"
                                        onclick="toggleDropdown(this)">
                                    <ul class="custom-dropdown-menu"
                                        style="display: none; position: absolute; right: 0; margin-top: 10px; background: white; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); z-index: 1000; list-style: none; padding: 0; width: 150px;">
                                        <li>
                                            <a href="{{ route('profile') }}"
                                                style="padding: 10px; display: block; color: black; text-decoration: none;">
                                                <i class='bx bx-user'></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('home') }}"
                                                style="padding: 10px; display: block; color: black; text-decoration: none;">
                                                <i class='bx bx-home'></i> Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                style="padding: 10px; display: block; color: red; text-decoration: none;">
                                                <i class='bx bx-power-off'></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <!-- Jika user tidak login -->
                                <em id="navigation">
                                    <button onclick="window.location.href='{{ route('login') }}'"
                                        style="border: none; padding: 5px 20px; background-color: #FF0B0B; color: white; border-radius: 5px; cursor: pointer; text-decoration: none;">
                                        Login
                                    </button>
                                </em>
                            @endauth
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-md-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        function toggleDropdown(element) {
            const dropdownMenu = element.nextElementSibling;

            // Tampilkan atau sembunyikan dropdown
            if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
                dropdownMenu.style.display = "block";
            } else {
                dropdownMenu.style.display = "none";
            }

            // Tutup dropdown lain saat yang ini dibuka
            document.addEventListener('click', function(event) {
                if (!element.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = "none";
                }
            });
        }
    </script>
@endsection
