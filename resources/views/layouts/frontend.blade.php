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

    {{-- Lottie --}}
    <script src="https://cdn.jsdelivr.net/npm/lottie-web@5.7.6/build/player/lottie.min.js"></script>

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('styles')

    <style>
        /* Sembunyikan seluruh konten saat halaman berpindah atau di-reload */
        body {
            overflow: hidden; /* Sembunyikan scroll saat animasi loading */
        }

        /* Pastikan animasi loading menutupi seluruh halaman */
        #lottie-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff; /* Bisa disesuaikan dengan warna background */
            z-index: 9999; /* Pastikan di atas konten lain */
            flex-direction: column; /* Menyusun animasi dan teks secara vertikal */
        }

        /* Teks Loading */
        #loading-text {
            font-size: 1.5rem;
            color: #333;
            margin-top: 20px; /* Jarak antara animasi dan teks */
            font-family: 'Raleway', sans-serif;
        }

        /* Sembunyikan konten lainnya (navbar, footer, dll) saat loading */
        .hidden-content {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Tempatkan ini di bagian atas halaman, sebelum konten dimuat -->
    <div id="lottie-loading">
        <div id="lottie"></div>
        <div id="loading-text">Loading...</div> <!-- Teks yang menampilkan "Loading..." -->
    </div>

    <header class="hidden-content">
        @include('frontend.header')
    </header>

    <main class="main-content hidden-content">
        @yield('content')
    </main>

    <footer class="footer hidden-content">
        @include('frontend.footer')
    </footer>

    <script src="{{ asset('assets/js/frontend.js') }}"></script>

    <script>
        // Menampilkan animasi loading sebelum halaman dimuat
        window.addEventListener('beforeunload', function () {
            document.getElementById('lottie-loading').style.display = 'flex';  // Menampilkan animasi loading saat perpindahan halaman
            document.body.style.overflow = 'hidden'; // Menghilangkan scroll saat loading
        });

        // Menunggu halaman sepenuhnya dimuat
        document.addEventListener("DOMContentLoaded", function () {
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie'), // ID elemen tempat animasi akan ditampilkan
                renderer: 'svg', // Bisa juga 'canvas' atau 'html'
                loop: true, // Animasi akan berulang
                autoplay: true, // Mulai otomatis
                path: '{{ asset('assets/loading-animation.json') }}' // Ganti dengan path ke file JSON Lottie Anda
            });
        });

        // Menghilangkan animasi loading setelah konten selesai dimuat
        window.addEventListener('load', function () {
            document.getElementById('lottie-loading').style.display = 'none';  // Menyembunyikan animasi setelah halaman selesai dimuat
            document.querySelector('header').classList.remove('hidden-content'); // Tampilkan navbar
            document.querySelector('main').classList.remove('hidden-content'); // Tampilkan konten utama
            document.querySelector('footer').classList.remove('hidden-content'); // Tampilkan footer
            document.body.style.overflow = 'auto'; // Kembalikan scroll setelah halaman dimuat
        });
    </script>

</body>

</html>
