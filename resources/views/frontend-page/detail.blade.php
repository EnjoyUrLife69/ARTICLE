@extends('layouts.frontend')

@section('styles')
    <style>
        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: #fff;
            color: #000;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 5%;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;

        }

        /* Wrapper untuk konten utama */
        .main-content {
            display: flex;
            flex-direction: column;
        }

        .category {
            font-weight: bold;
            color: #ff4444;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 20px 0;
        }

        .author {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .author-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #eee;
        }

        .author-img img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .share-container {
            position: relative;
        }

        .share-btn {
            background: #000;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .social-buttons {
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 10px;
            opacity: 0;
            pointer-events: none;
            transition: 0.3s;
        }

        .share-container.active .social-buttons {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(-50%) translateX(-9px);
        }

        .social-btn {
            background: #000;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image {
            width: 100%;
            height: 400px;
            background: #eee;
            margin: 20px 0;
        }

        .main-image img {
            width: 100%;
            height: 450px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .content {
            font-size: 1.1rem;
            margin: 20px 10px;
            line-height: 1.8;
        }

        .content p {
            font-family: 'Rubik', sans-serif;
            margin-bottom: 16px;
            line-height: 1.6;
        }


        /* Sidebar Container */
        .sidebar-container {
            position: relative;
            margin-top: 70%;
            width: 100%;
        }

        .sidebar {
            background-color: #f5f5f5;
            padding: 20px;
            width: 380px;
            height: fit-content;
            position: sticky;
            top: 14%;
            transition: all 0.3s ease-in-out;
        }

        .sidebar.sticky-end {
            position: absolute;
            bottom: 0;
        }

        .popular-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popular-title::before,
        .popular-title::after {
            content: '';
            flex-grow: 1;
            height: 1px;
            background: #ccc;
            margin: 0 10px;
        }

        /* Popular Posts List */
        .popular-posts {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Individual Post Item */
        .popular-post {
            display: flex;
            gap: 15px;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .popular-post:hover {
            background-color: rgba(0, 0, 0, 0.05);
            transform: scale(1.02);
        }

        /* Post Image */
        .popular-img {
            width: 80px;
            height: 80px;
            border-radius: 6px;
            overflow: hidden;
        }

        .popular-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .popular-post:hover .popular-img img {
            transform: scale(1.1);
        }

        /* Post Content */
        .popular-content {
            flex: 1;
            margin-left: 5px;
        }

        .popular-category {
            color: #ff4444;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .popular-post-title {
            font-family: 'Playfair Display', serif;
            font-size: 14px;
            color: #1c1c1c;
            line-height: 1.5;
            word-spacing: 2px;
            letter-spacing: 0.3px;
            margin: 0;
        }

        /* More Button (Minimalis) */
        .more-posts-btn {
            width: 100%;
            padding: 10px;
            background-color: #000;
            border: 1px solid #151515;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
            text-transform: uppercase;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .more-posts-btn:hover {
            background-color: #fff;
            color: #000;
            border-color: #fff;
        }

        /* DIVIDER */
        .end-article-divider {
            position: relative;
            margin: 60px 0;
        }

        .end-article-divider hr {
            border: none;
            height: 2px;
            background-color: #E5E5E5;
        }

        .end-article-divider p {
            position: absolute;
            right: 0;
            top: 2px;
            font-weight: bold;
            bottom: -10px;
            color: rgba(0, 0, 0, 0.5);
            /* Warna hitam samar */
            font-style: italic;
            font-size: 14px;
        }

        .hidden {
            display: none;
        }


        /* COMMENT STYLES */
        #disqus_thread,
        #disqus_thread * {
            color: #ffffff !important;
            background-color: #121212 !important;
            padding: 1% 1% 0 1%;
        }

        #disqus_thread-card {
            border-radius: 2%;
            background: #121212;
            padding: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            /* Menambahkan shadow lembut */
        }

        .comment-divider {
            text-align: center;
            margin: 40px 0;
            position: relative;
        }

        /* Tooltip Styling */
        .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-8px);
            background: black;
            color: white;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 5px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, transform 0.2s ease;
            pointer-events: none;
        }

        .social-btn:hover .tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-12px);
        }

        .like-btn:hover .tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-12px);
        }

        .tooltip-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip-text {
            visibility: hidden;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 10px;
            border-radius: 5px;
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            font-size: 12px;
        }

        .tooltip-container:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }







        /* Responsive Adjustments */
        @media (max-width: 968px) {
            .container {
                grid-template-columns: 1fr;
                gap: 20px;
                margin-bottom: 60px;
            }

            .sidebar-container {
                margin-top: 0;
                order: 1;
                position: relative;
                margin-bottom: 80px;
            }

            .sidebar {
                width: 100%;
                /* Membuat sidebar full width pada layar kecil */
                position: static;
                /* Menghilangkan sticky behavior pada mobile */
                margin-bottom: 40px;
                padding-bottom: 20px;
                /* Menambah padding bawah */

            }

            .comment {
                order: 2;
                /* Memastikan komentar ada di bawah sidebar */
                margin-bottom: 60px;
                /* Menambah space sebelum footer */

            }

            /* Memperbaiki tampilan popular posts pada layar kecil */
            .popular-posts {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 15px;
                margin-bottom: 20px;
            }

            .popular-post {
                width: 100%;
            }

            .popular-img {
                width: 100px;
                height: 100px;
            }

            /* Memastikan konten terakhir memiliki margin yang cukup */
            .container>*:last-child {
                margin-bottom: 80px;
            }
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                padding: 15px;
                margin-bottom: 80px;
            }

            .title {
                font-size: 1.5rem;
            }

            .main-image {
                height: 250px;
            }

            .quote {
                margin-top: 160px;
            }

            .blog-wrapper .sidebar {
                margin-top: 30px;
            }

            .blog-wrapper .popular-post-image {
                height: 200px;
            }

            .popular-posts {
                grid-template-columns: 1fr;
                margin-bottom: 30px;
            }

            .sidebar-container {
                margin-bottom: 100px;
                /* Space lebih besar untuk mobile */
            }

            .popular-post {
                padding: 8px;
            }

            .popular-img {
                width: 80px;
                height: 80px;
            }

            .popular-content {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .container {
                margin-bottom: 100px;
                /* Space maksimal untuk device terkecil */
            }

            .sidebar-container {
                margin-bottom: 120px;
            }

            .popular-title {
                font-size: 16px;
            }

            .popular-category {
                font-size: 11px;
            }

            .popular-post-title {
                font-size: 13px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <main>
            <div class="row g-0 align-items-center">
                <div class="col-auto">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 6h8m-8 4h12M6 14h8m-8 4h12" />
                    </svg>
                </div>
                <div class="col-auto ms-2">
                    <div class="category">{{ $articles->categorie->name }}</div>
                </div>
            </div>
            <h1 class="title">{{ $articles->title }}</h1>
            <div class="meta">
                <div class="author">
                    <div class="author-img"><img src="{{ asset('storage/images/users/' . $articles->user->image) }}"
                            alt=""></div>
                    <div class="author-info">
                        <div><b><em>{{ $articles->user->name }}</em></b></div>
                        <div>{{ \Carbon\Carbon::parse($articles->release_date)->translatedFormat('D , jS F Y') }}</div>
                    </div>
                </div>
                <div class="actions">
                    <div class="share-container">
                        <button class="share-btn" onclick="toggleShare()">
                            <svg id="share-icon" class="w-6 h-6 text-gray-800 dark:text-white"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M7.926 10.898 15 7.727m-7.074 5.39L15 16.29M8 12a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm0-11a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                            </svg>
                        </button>
                        <div class="social-buttons">
                            <button class="social-btn" onclick="shareToTwitter()">
                                <span class="tooltip">Twitter</span>
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M13.795 10.533 20.68 2h-3.073l-5.255 6.517L7.69 2H1l7.806 10.91L1.47 22h3.074l5.705-7.07L15.31 22H22l-8.205-11.467Zm-2.38 2.95L9.97 11.464 4.36 3.627h2.31l4.528 6.317 1.443 2.02 6.018 8.409h-2.31l-4.934-6.89Z" />
                                </svg>
                            </button>

                            <button class="social-btn" onclick="shareToFacebook()">
                                <span class="tooltip">Facebook</span>
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <button class="social-btn" onclick="copyToClipboard()">
                                <span class="tooltip">Copy Link</span>
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @php
                        $isLiked = Auth::check() && $articles->likes->contains('user_id', Auth::id());
                    @endphp

                    <button id="like-btn" class="tooltip-container share-btn"
                        onclick="toggleLike('{{ $articles->id }}', {{ Auth::check() ? 'true' : 'false' }})">
                        <span id="tooltip-text" class="tooltip-text">
                            {{ $isLiked ? 'Unlike this article' : 'Like this article' }}
                        </span>

                        <svg id="heart-outline" class="{{ $isLiked ? 'hidden' : '' }}" width="24" height="24"
                            viewBox="0 -2 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg>

                        <svg id="heart-filled" class="{{ $isLiked ? '' : 'hidden' }}" width="24" height="24"
                            viewBox="0 -2 24 24" fill="currentColor" transform="scale(1.2, 1.05)">
                            <path
                                d="M12.75 20.66l6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                        </svg>
                    </button>


                </div>
            </div>
            <div class="main-image"><img src="{{ asset('storage/images/articles/' . $articles->cover) }}" alt="">
            </div><br><br>
            <div class="quote" style="color: #7e7e7e; margin-left: 5px"><em>Lorem ipsum dolor sit amet consectetur</em>
            </div>
            <hr style="margin-top: 2%; border: none; height: 1px; background-color: rgba(0, 0, 0, 0.1);">
            <div class="content">
                <p>{!! $articles->content !!}</p>
            </div>

            <div class="end-article-divider">
                <hr>
                <p>Ends of Article</p>
            </div>


            <div class="comment" style="margin-top: 5%; order: 2;">
                <div class="card" id="disqus_thread-card">
                    <div class="card-body" id="disqus_thread"></div>
                </div>
            </div>
        </main>

        <div class="sidebar-container">
            <aside class="sidebar">
                <h2 class="popular-title">POPULAR</h2>
                <div class="popular-posts">
                    @foreach ($article_trending as $data)
                        <a href="{{ url('/article/' . $data->id) }}">
                            <article class="popular-post">
                                <div class="popular-img">
                                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                        alt="Post thumbnail">
                                </div>
                                <div class="popular-content">
                                    <span class="popular-category"><b>{{ $data->categorie->name }}</b></span>
                                    <h3 class="popular-post-title"> {{ $data->title }}</h3>
                                </div>
                            </article>
                            <hr style="border: none; height: 1px; background-color: rgba(0, 0, 0, 0.1);">
                        </a>
                    @endforeach
                    <button class="more-posts-btn">MORE</button>
                </div>
            </aside>
        </div>

        <!-- Elemen batas akhir -->
        <div class="stop-sticky"></div>
    </div>

    <br>

    <script>
        function toggleLike(articleId, isLoggedIn) {
            // Check if user is logged in
            if (!isLoggedIn) {
                Toastify({
                    text: "Sign in to like this article",
                    duration: 3000,
                    gravity: "center",
                    position: "right",
                    style: {
                        background: "black",
                        color: "white"
                    }
                }).showToast();
                return;
            }

            let baseUrl = window.location.origin + '/ARTICLE/public';
            let button = document.getElementById('like-btn');
            let tooltipText = document.getElementById('tooltip-text');
            let heartOutline = document.getElementById('heart-outline');
            let heartFilled = document.getElementById('heart-filled');

            // UI langsung berubah (Optimistic UI Update)
            let isCurrentlyLiked = !heartOutline.classList.contains('hidden');

            if (isCurrentlyLiked) {
                heartOutline.classList.add('hidden');
                heartFilled.classList.remove('hidden');
            } else {
                heartOutline.classList.remove('hidden');
                heartFilled.classList.add('hidden');
            }

            fetch(`${baseUrl}/like/${articleId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.liked) {
                        heartOutline.classList.add('hidden');
                        heartFilled.classList.remove('hidden');
                    } else {
                        heartOutline.classList.remove('hidden');
                        heartFilled.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Jika error, kembalikan UI seperti sebelumnya
                    if (isCurrentlyLiked) {
                        heartOutline.classList.remove('hidden');
                        heartFilled.classList.add('hidden');
                    } else {
                        heartOutline.classList.add('hidden');
                        heartFilled.classList.remove('hidden');
                    }
                });
        }



        function toggleShare() {
            const container = document.querySelector('.share-container');
            const shareIcon = document.getElementById("share-icon");

            container.classList.toggle('active');

            if (container.classList.contains('active')) {
                shareIcon.innerHTML =
                    `
            <path fill="white" d="M17.5 3a3.5 3.5 0 0 0-3.456 4.06L8.143 9.704a3.5 3.5 0 1 0-.01 4.6l5.91 2.65a3.5 3.5 0 1 0 .863-1.805l-5.94-2.662a3.53 3.53 0 0 0 .002-.961l5.948-2.667A3.5 3.5 0 1 0 17.5 3Z"/>`;
            } else {
                shareIcon.innerHTML =
                    `
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                d="M7.926 10.898 15 7.727m-7.074 5.39L15 16.29M8 12a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm0-11a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />`;
            }
        }

        // COPY LINK KA CLIPBOARD
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert("Link telah disalin!");
            }).catch(err => {
                console.error("Gagal menyalin:", err);
            });
        }
        // SHARE KA TWITTER
        function shareToTwitter() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://twitter.com/intent/tweet?url=${url}`, '_blank');
        }
        // SHARE KA FACEBOOK
        function shareToFacebook() {
            const url = encodeURIComponent(window.location.href);
            const facebookShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            window.open(facebookShareUrl, '_blank');
        }
    </script>

    {{-- scripts sidebar sticky --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector(".sidebar");
            const sidebarContainer = sidebar.parentElement; // Container sidebar
            const stopPoint = document.querySelector(".stop-sticky"); // Elemen batas akhir

            function handleScroll() {
                const sidebarRect = sidebar.getBoundingClientRect();
                const stopRect = stopPoint.getBoundingClientRect();

                if (stopRect.top <= sidebarRect.bottom) {
                    sidebar.classList.add("sticky-end");
                } else {
                    sidebar.classList.remove("sticky-end");
                }
            }

            window.addEventListener("scroll", handleScroll);
        });
    </script>

    <script>
        var disqus_config = function() {
            this.page.url = "{{ url()->current() }}"; // URL halaman artikel
            this.page.identifier = "{{ $articles->id }}"; // ID artikel sebagai identifier
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = 'https://article-blog-2.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>

    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
            Disqus.</a>
    </noscript>


    <script></script>



    <br><br><br><br>
@endsection
