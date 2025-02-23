<h1 class="site-title">LOREM IPSUM</h1>
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <div class="datetime">
                <i class="far fa-calendar-alt"></i>
                <span id="date"></span>
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
            <li class="nav-item">
                <a href="#" class="nav-link">FASHION</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">BEAUTY</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">FOOD</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">ENTERTAINMENT</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">ZODIAC</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link">MORE</a>
                <div class="dropdown-content">
                    <a href="#"><i class="fas fa-heart"></i>&nbsp;&nbsp;LOREM IPSUM</a>
                    <a href="#"><i class="fas fa-plane"></i>&nbsp;&nbsp;LOREM IPSUM</a>
                    <a href="#"><i class="fas fa-briefcase"></i>&nbsp;&nbsp;LOREM IPSUM</a>
                </div>
            </li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search nav-icon"></i>
            <div class="user-dropdown">
                <i class="fas fa-user nav-icon"></i>
                <div class="user-dropdown-content">
                    <a href="{{ route('login') }}"><i class="fas fa-user-circle"></i>&nbsp;&nbsp;LOGIN</a>
                    <a href="#"><i class="fas fa-cog"></i>&nbsp;&nbsp;Lorem Ipsum</a>
                    <a href="#"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Lorem Ipsum</a>
                </div>
            </div>
        </div>
    </div>
</nav>

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
            day: 'numeric'
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
