<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articles</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap-grid.min.css">

    {{-- font --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;700&display=swap" rel="stylesheet">

    {{-- Toastify --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('styles')
</head>

<body>

    <header>
        @include('frontend.header')
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        @include('frontend.footer')
    </footer>

    {{-- SCRIPT BAGIAN 1 (SLIDESHOW) --}}
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        let slideInterval;

        function showSlide(n) {
            // Remove active class from all slides and indicators
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            // Set current slide index
            currentSlide = (n + slides.length) % slides.length;

            // Add active class to current slide and indicator
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.add('active');
        }

        function changeSlide(n) {
            showSlide(currentSlide + n);
            resetInterval();
        }

        function goToSlide(n) {
            showSlide(n);
            resetInterval();
        }

        function resetInterval() {
            // Clear existing interval and start a new one
            clearInterval(slideInterval);
            startSlideshow();
        }

        function startSlideshow() {
            // Auto advance slide every 5 seconds
            slideInterval = setInterval(() => {
                changeSlide(1);
            }, 10000);
        }

        // Start the slideshow when the page loads
        startSlideshow();
    </script>

    {{-- SCRIPT BAGIAN 3 --}}
    <script>
        const categoryLinks = document.querySelectorAll('.category-link');
        const articles = document.querySelectorAll('.article-card2');
        const loader = document.querySelector('.loader');

        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                categoryLinks.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');

                // Show loader
                loader.classList.add('active');

                // Hide articles
                articles.forEach(article => {
                    article.style.opacity = '0';
                });

                // Simulate loading
                setTimeout(() => {
                    // Hide loader
                    loader.classList.remove('active');

                    // Show articles with animation
                    articles.forEach(article => {
                        article.style.opacity = '1';
                        article.classList.remove('reload-animation');
                        void article.offsetWidth; // Trigger reflow
                        article.classList.add('reload-animation');
                    });
                }, 500);
            });
        });
    </script>

</body>

</html>
