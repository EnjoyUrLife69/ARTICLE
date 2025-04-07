@extends('layouts.frontend')

@section('content')
    <!-- Hero Category Header -->
    <div class="category-hero">
        <div class="container">
            <!-- Memeriksa apakah $category ada, jika tidak tampilkan "All Articles" -->
            <h1 class="category-title">{{ isset($category) ? strtoupper($category->name) : 'ALL ARTICLES' }}</h1>
            <p class="category-subtitle">
                <span class="category-count">{{ $articles->total() }}</span> Articles found
                @if (isset($category))
                    in this category
                @else
                    across all categories
                @endif
            </p>
            <div class="category-decoration">
                <span class="category-line"></span>
                <span class="category-dot"></span>
                <span class="category-line"></span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container" style="width: 1000px; margin-top: -60px">
        <div class="content-wrapper" style="margin-left: -160px">
            <!-- Article Grid Section -->
            <div class="articles-section" style="width: 850px">
                <h2 class="section-heading">Artikel Terbaru</h2>

                @if ($articles->count() > 0)
                    <div class="articlee-grid">
                        @foreach ($articles as $article)
                            <div class="article-card">
                                <div class="article-image">
                                    <a href="{{ url('/article/' . $article->id) }}">
                                        <img src="{{ asset('storage/images/articles/' . $article->cover) }}"
                                            alt="{{ $article->title }}">
                                    </a>
                                    <div class="article-date">{{ $article->created_at->format('M d, Y') }}</div>
                                </div>
                                <div class="article-content">
                                    <a href="{{ url('/article/' . $article->id) }}"
                                        class="article-title">{{ $article->title }}</a><br>
                                    <p class="article-excerpt">{{ Str::limit(strip_tags($article->description), 120) }}</p>
                                    <a href="{{ url('/article/' . $article->id) }}" class="read-more">Baca Selengkapnya</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container">
                        {{ $articles->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="far fa-file-alt"></i>
                        </div>
                        <h3 class="empty-title">Tidak Ada Artikel</h3>
                        <p class="empty-text">Belum ada artikel dalam kategori ini.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Categories Widget -->
                <div class="widget">
                    <h3 class="widget-title">Kategori</h3>

                    <div class="category-search">
                        <input type="text" id="categorySearch" placeholder="Cari kategori...">
                    </div>

                    <ul class="category-list" id="categoryList">
                        <!-- Link ke Semua Kategori -->
                        <li class="{{ request()->is('category/all') ? 'active' : '' }}">
                            <a href="{{ url('/category/all') }}">
                                <span class="category-name">Semua Kategori</span>
                            </a>
                        </li>

                        <!-- Daftar kategori lain -->
                        @foreach ($categories as $cat)
                            <li class="{{ request()->is('category/' . $cat->id) ? 'active' : '' }} category-item">
                                <a href="{{ url('/category/' . $cat->id) }}">
                                    <span class="category-name">{{ $cat->name }}</span>
                                    <span class="category-count">{{ $cat->articles_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Videos Section -->
    {{-- @php
        $categoryVideos = $category
            ->articles()
            ->whereHas('media', function ($query) {
                $query->where('type', 'youtube');
            })
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $mainVideo = $categoryVideos->count() > 0 ? $categoryVideos->shift() : null;
    @endphp

    @if ($mainVideo)
        <div class="videos-section">
            <div class="container">
                <h2 class="section-heading">Video {{ strtoupper($category->name) }}</h2>

                <div class="video-showcase">
                    <div class="featured-video">
                        <a href="{{ url('/article/' . $mainVideo->id) }}?autoplay=1" class="video-link">
                            <div class="featured-video-image">
                                <img src="https://img.youtube.com/vi/{{ $mainVideo->media->where('type', 'youtube')->first()->path }}/maxresdefault.jpg"
                                    alt="{{ $mainVideo->title }}">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </a>
                        <div class="featured-video-content">
                            <h3 class="featured-video-title">{{ $mainVideo->title }}</h3>
                            <p class="featured-video-description">{{ Str::limit($mainVideo->description, 250) }}</p>
                        </div>
                    </div>

                    <div class="video-list">
                        @foreach ($categoryVideos as $video)
                            <div class="video-item">
                                <a href="{{ url('/article/' . $video->id) }}?autoplay=1" class="video-link">
                                    <div class="video-thumbnail">
                                        <img src="https://img.youtube.com/vi/{{ $video->media->where('type', 'youtube')->first()->path }}/mqdefault.jpg"
                                            alt="{{ $video->title }}">
                                        <div class="play-button-small">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                    <h4 class="video-title">{{ Str::limit($video->title, 100) }}</h4>
                                </a>
                            </div>
                        @endforeach

                        @if ($category->articles()->whereHas('media', function ($query) {
            $query->where('type', 'youtube');
        })->count() > 3)
                            <div class="more-videos">
                                <a href="{{ url('/videos?category=' . $category->id) }}" class="more-videos-btn">Lihat
                                    Semua Video</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <script>
        document.getElementById('categorySearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const categories = document.querySelectorAll('.category-item');

            categories.forEach(category => {
                const categoryName = category.querySelector('.category-name').textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    category.style.display = 'block';
                } else {
                    category.style.display = 'none';
                }
            });
        });
    </script>

@endsection

<style>
    /* ===== GLOBAL STYLES ===== */
    :root {
        --primary-color: #c4156e;
        --primary-light: #e6267e;
        --primary-dark: #9c0f57;
        --text-dark: #333333;
        --text-medium: #666666;
        --text-light: #888888;
        --bg-light: #f8f9fa;
        --bg-white: #ffffff;
        --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 8px 20px rgba(0, 0, 0, 0.1);
        --border-radius-sm: 6px;
        --border-radius-md: 10px;
        --border-radius-lg: 16px;
        --spacing-xs: 5px;
        --spacing-sm: 10px;
        --spacing-md: 20px;
        --spacing-lg: 30px;
        --spacing-xl: 50px;
    }

    body {
        font-family: 'Roboto', 'Open Sans', sans-serif;
        line-height: 1.6;
        color: var(--text-dark);
        background-color: var(--bg-light);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ===== HERO SECTION ===== */
    .category-hero {
        margin-top: 20px;
        margin-left: -14px;
        width: 1238px;
        background: #1a1a1a;
        /* Warna dasar gelap */
        color: white;
        padding: var(--spacing-xl) 0;
        margin-bottom: var(--spacing-xl);
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        /* Menambahkan bayangan */
        border-bottom: 3px solid #444;
        /* Border subtle */
    }

    /* Menambahkan pattern overlay */
    .category-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTAwIDEwMEw0MDAgNDAwTTUwMCAwTDAgNTAwIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+');
        opacity: 0.2;
    }

    /* Menambahkan gradient overlay */
    .category-hero::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(40, 40, 40, 0.7) 0%, rgba(10, 10, 10, 0.9) 100%);
        z-index: 1;
    }

    /* Memposisikan konten di atas overlay */
    .category-hero .container {
        position: relative;
        z-index: 2;
    }

    .category-title {
        font-size: 3rem;
        margin: 0 0 var(--spacing-sm);
        font-weight: 800;
        letter-spacing: 3px;
        text-transform: uppercase;
        position: relative;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Menambahkan garis dekoratif */
    .category-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 3px;
        background: #fff;
        margin: 15px auto 0;
    }

    .category-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 15px 0 0;
        font-weight: 300;
        /* Font lebih tipis */
        letter-spacing: 1px;
    }

    .category-decoration {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 15px;
    }

    .category-line {
        display: inline-block;
        width: 30px;
        height: 1px;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .category-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #fff;
        margin: 0 10px;
    }

    .category-count {
        font-weight: 700;
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        padding: 2px 8px;
        border-radius: 3px;
    }

    /* ===== MAIN CONTENT LAYOUT ===== */
    .content-wrapper {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 40px;
        margin-bottom: var(--spacing-xl);
    }


    /* Section Headers */
    .section-heading {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 var(--spacing-md);
        padding-bottom: var(--spacing-sm);
        border-bottom: 2px solid #eee;
        position: relative;
    }

    .section-heading::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background-color: var(--primary-color);
        bottom: -2px;
        left: 0;
    }

    /* ===== ARTICLE GRID ===== */
    .articlee-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(250px, 1fr));
        gap: 30px;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
    }

    .article-card {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        width: 105%;
        height: 100%;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .article-grid {
            grid-template-columns: repeat(2, minmax(250px, 1fr));
            /* 2 columns on medium screens */
        }
    }

    @media (max-width: 768px) {
        .article-grid {
            grid-template-columns: 1fr;
            /* 1 column on small screens */
        }
    }



    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .article-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .article-card:hover .article-image img {
        transform: scale(1.05);
    }

    .article-date {
        position: absolute;
        top: var(--spacing-sm);
        right: var(--spacing-sm);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: 0.8rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
    }

    .article-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .article-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        line-height: 1.4;
        margin: 0 0 15px;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .article-title:hover {
        color: var(--primary-color);
    }

    .article-excerpt {
        color: var(--text-medium);
        margin: 0 0 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .read-more {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        margin-top: auto;
        transition: all 0.3s ease;
    }

    .read-more:after {
        content: '→';
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .read-more:hover {
        color: var(--primary-dark);
    }

    .read-more:hover:after {
        transform: translateX(5px);
    }


    /* ===== EMPTY STATE ===== */
    .empty-state {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-md);
        padding: var(--spacing-xl);
        text-align: center;
        box-shadow: var(--shadow-sm);
    }

    .empty-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: var(--spacing-md);
    }

    .empty-title {
        font-size: 1.5rem;
        margin-bottom: var(--spacing-sm);
        color: var(--text-medium);
    }

    .empty-text {
        color: var(--text-light);
        max-width: 400px;
        margin: 0 auto;
    }

    /* ===== PAGINATION ===== */
    .pagination-container {
        margin-top: var(--spacing-lg);
        display: flex;
        justify-content: center;
    }

    /* Black and white pagination styling */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
    }

    .pagination li {
        display: inline-flex;
    }

    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        background-color: white;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .pagination li a:hover {
        background-color: #f5f5f5;
        border-color: #bbb;
    }

    .pagination li.active span {
        background-color: #333;
        border-color: #333;
        color: white;
    }

    .pagination li.disabled span {
        background-color: #f9f9f9;
        color: #aaa;
        cursor: not-allowed;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
        position: sticky;
        top: 20px;
        height: max-content;
    }

    .category-search {
        margin-bottom: 15px;
        position: relative;
    }

    .category-search input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #eee;
        border-radius: var(--border-radius-sm);
        font-size: 0.9rem;
    }

    .category-search input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    /* Tambahkan max-height dan scrollbar untuk kategori */
    .category-list {
        max-height: 350px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color) #f5f5f5;
    }

    .category-list::-webkit-scrollbar {
        width: 6px;
    }

    .category-list::-webkit-scrollbar-track {
        background: #f5f5f5;
    }

    .category-list::-webkit-scrollbar-thumb {
        background-color: var(--primary-color);
        border-radius: 20px;
    }

    .widget {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-md);
        padding: var(--spacing-md);
        box-shadow: var(--shadow-sm);
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 var(--spacing-md);
        padding-bottom: var(--spacing-sm);
        border-bottom: 2px solid #eee;
        position: relative;
    }

    .widget-title::after {
        content: '';
        position: absolute;
        width: 40px;
        height: 2px;
        background-color: var(--primary-color);
        bottom: -2px;
        left: 0;
    }

    /* Category List */
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
    }

    .category-list li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-sm) var(--spacing-md);
        text-decoration: none;
        color: var(--text-dark);
        border-radius: var(--border-radius-sm);
        background-color: #f5f5f5;
        transition: all 0.3s ease;
    }

    .category-list li a:hover {
        background-color: #eee;
        transform: translateX(5px);
    }

    .category-list li.active a {
        background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
        color: #fff;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .category-name {
        font-weight: 500;
    }

    .category-count {
        background-color: rgba(0, 0, 0, 0.1);
        color: inherit;
        font-size: 0.8rem;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* Trending Articles */
    .trending-articles {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .trending-article {
        display: flex;
        gap: var(--spacing-sm);
        text-decoration: none;
        background-color: #f5f5f5;
        border-radius: var(--border-radius-sm);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .trending-article:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
    }

    .trending-image {
        width: 90px;
        height: 90px;
        flex-shrink: 0;
    }

    .trending-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .trending-content {
        padding: var(--spacing-sm);
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .trending-title {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-dark);
        margin: 0 0 5px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .trending-date {
        font-size: 0.8rem;
        color: var(--text-light);
        margin-top: auto;
    }

    /* ===== VIDEOS SECTION ===== */
    .videos-section {
        background-color: #f0f2f5;
        padding: var(--spacing-xl) 0;
        margin-top: var(--spacing-xl);
    }

    .video-showcase {
        display: grid;
        grid-template-columns: 1fr 350px;
        grid-gap: var(--spacing-lg);
        margin-top: var(--spacing-lg);
    }

    /* Featured Video */
    .featured-video {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .featured-video-image {
        position: relative;
        height: 0;
        padding-bottom: 56.25%;
        /* 16:9 ratio */
    }

    .featured-video-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background-color: rgba(196, 21, 110, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .play-button i {
        color: white;
        font-size: 30px;
    }

    .video-link:hover .play-button {
        transform: translate(-50%, -50%) scale(1.1);
        background-color: var(--primary-color);
    }

    .featured-video-content {
        padding: var(--spacing-md);
    }

    .featured-video-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 var(--spacing-sm);
        color: var(--text-dark);
    }

    .featured-video-description {
        color: var(--text-medium);
        margin: 0;
        line-height: 1.6;
    }

    /* Video List */
    .video-list {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .video-item {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease;
    }

    .video-item:hover {
        transform: translateY(-3px);
    }

    .video-thumbnail {
        position: relative;
        height: 0;
        padding-bottom: 56.25%;
        /* 16:9 ratio */
    }

    .video-thumbnail img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-button-small {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background-color: rgba(196, 21, 110, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .play-button-small i {
        color: white;
        font-size: 18px;
    }

    .video-link:hover .play-button-small {
        transform: translate(-50%, -50%) scale(1.1);
        background-color: var(--primary-color);
    }

    .video-title {
        padding: var(--spacing-sm);
        font-size: 0.95rem;
        font-weight: 500;
        margin: 0;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .more-videos {
        text-align: center;
        margin-top: var(--spacing-sm);
    }

    .more-videos-btn {
        display: block;
        background-color: var(--primary-color);
        color: white;
        text-decoration: none;
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--border-radius-sm);
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .more-videos-btn:hover {
        background-color: var(--primary-light);
    }
</style>
