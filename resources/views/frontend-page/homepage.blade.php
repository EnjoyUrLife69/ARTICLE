@extends('layouts.frontend')

@section('content')
    <!-- Slideshow section / BAGIAN 1 -->
    <div class="slideshow-container">
        @foreach ($article_trending_slideshow as $index => $article)
            <a href="{{ url('/article/' . $article->id) }}" class="slide-link" data-article-id="{{ $article->id }}">
                <div class="slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img src="{{ asset('storage/images/articles/' . $article->cover) }}" alt="{{ $article->title }}">
                    <div class="slide-content">
                        <div class="content-wrapper">
                            <span class="slide-tag">
                                <a href="{{ url('/category/' . $article->categorie->id) }}"
                                    style="color: white; text-decoration: none;">
                                    {{ $article->categorie->name }}
                                </a>
                            </span>
                            <h2 class="slide-title">{{ $article->title }}</h2>
                            <p class="slide-description">{{ $article->description }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach

        <div class="slide-nav">
            <button class="prev-btn" type="button" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path>
                </svg>
            </button>
            <button class="next-btn" type="button" aria-label="Next slide">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                </svg>
            </button>
        </div>

        <div class="slide-indicators">
            @foreach ($article_trending_slideshow as $index => $article)
                <div class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
            @endforeach
        </div>

        <div class="slide-counter">
            <span class="current-slide">1</span>
            <span class="total-slides">/ {{ count($article_trending_slideshow) }}</span>
        </div>
    </div>

    <!-- Article grid section / BAGIAN 2 -->
    <div class="article-grid">
        @foreach ($article_trending as $data)
            <a href="{{ url('/article/' . $data->id) }}">
                <article class="article-card">
                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}" alt="Article thumbnail"
                        class="article-image">
                    <div class="article-content">
                        <div class="article-category">{{ $data->categorie->name }}</div>
                        <h3 class="article-title">{{ $data->title }}</h3>
                    </div>
                </article>
            </a>
        @endforeach
    </div>

    <!-- Article Category section / BAGIAN 3 -->
    <section class="article-category-section">
        <div class="container">
            <div class="categories-nav">
                <!-- Tambahkan data-category="all" untuk menampilkan semua artikel -->
                <a href="#" class="category-link active" data-category="all">ALL</a>

                @foreach ($popular_categories as $data)
                    <a href="#" class="category-link" data-category="{{ $data->id }}">
                        {{ strtoupper($data->name) }} ({{ $data->articles_count }})
                    </a>
                @endforeach

                <button class="more-btn">MORE</button>
            </div>

            <div class="loader">
                <div class="loader-spinner"></div>
            </div>

            <div class="blog-content">
                <div class="blog-grid">
                    @foreach ($articless as $data)
                        <div class="article-card2" data-category="{{ $data->categorie_id }}">
                            <div class="article-image">
                                <a href="{{ url('/article/' . $data->id) }}"><img
                                        src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                        alt="Article Image"></a>
                            </div>
                            <div class="article-date">{{ $data->created_at->format('M d, Y') }}</div>
                            <a href="{{ url('/article/' . $data->id) }}" class="article-title-2">{{ $data->title }}</a>
                        </div>
                    @endforeach
                </div>

                <div class="sidebar"
                    style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 class="sidebar-title"
                        style="font-size: 18px; font-weight: 700; margin-bottom: 15px; border-bottom: 2px solid #ddd; padding-bottom: 8px; color: #343a40;">
                        CATEGORIES
                    </h3>

                    <ul class="categories-list" style="list-style: none; padding-left: 0; margin: 0;">
                        @foreach ($categories as $data)
                            <li
                                style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                                <a href="{{ url('/category/' . $data->id) }}"
                                    style="text-decoration: none; color: #495057; font-weight: 500; transition: color 0.3s;"
                                    onmouseover="this.style.color='#0d6efd'" onmouseout="this.style.color='#495057'">
                                    {{ $data->name }}
                                </a>
                                <span
                                    style="font-size: 13px; color: #6c757d; background-color: #e9ecef; padding: 2px 8px; border-radius: 12px;">
                                    {{ $data->articles_count }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ url('/category/all') }}" class="sidebar-more"
                        style="display: block; text-align: center; margin-top: 20px; background-color: #0d6efd; color: white; padding: 10px 15px; border-radius: 6px; font-weight: 600; text-decoration: none; transition: background-color 0.3s;"
                        onmouseover="this.style.backgroundColor='#0b5ed7'"
                        onmouseout="this.style.backgroundColor='#0d6efd'">
                        VIEW MORE
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ARTICLE HISTORY SECTION - BAGIAN 5 --}}
    <br><br>
    <div class="section-title">
        <h2>READING HISTORY</h2>
    </div>

    @if (count($article_history) > 0)
        <div class="history-container">
            <div class="history-scroll-container">
                <div class="history-scroll-arrow left-arrow">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="history-articles-scroll">
                    @foreach ($article_history->take(12) as $index => $article)
                        <div class="history-article">
                            <a href="{{ url('/article/' . $article->id) }}" class="history-link">
                                <div class="history-img-container">
                                    <img src="{{ asset('storage/images/articles/' . $article->cover) }}"
                                        alt="{{ $article->title }}" class="history-img">
                                    <div class="history-overlay">
                                        <div class="history-category">{{ $article->categorie->name }}</div>
                                    </div>
                                </div>
                                <h3 class="history-title">{{ Str::limit($article->title, 90) }}</h3>
                                <div class="history-date">
                                    <i class="far fa-clock"></i> Last read
                                    {{ $index === 0 ? 'just now' : ($index === 1 ? '1 article ago' : $index . ' articles ago') }}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="history-scroll-arrow right-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    @else
        <div class="no-history-message">
            <div class="no-history-icon">
                <i class="far fa-bookmark"></i>
            </div>
            <h4>No Reading History Yet</h4>
            <p>Articles you read will appear here.</p>
        </div>
    @endif
    <script>
        // Add this to your JavaScript file or include in a script tag
        document.addEventListener('DOMContentLoaded', function() {
            const scrollContainer = document.querySelector('.history-articles-scroll');
            const leftArrow = document.querySelector('.left-arrow');
            const rightArrow = document.querySelector('.right-arrow');

            if (scrollContainer && leftArrow && rightArrow) {
                // Scroll left
                leftArrow.addEventListener('click', function() {
                    scrollContainer.scrollBy({
                        left: -300,
                        behavior: 'smooth'
                    });
                });

                // Scroll right
                rightArrow.addEventListener('click', function() {
                    scrollContainer.scrollBy({
                        left: 300,
                        behavior: 'smooth'
                    });
                });

                // Hide arrows based on scroll position
                function updateArrows() {
                    const isAtStart = scrollContainer.scrollLeft === 0;
                    const isAtEnd = scrollContainer.scrollLeft >= (scrollContainer.scrollWidth - scrollContainer
                        .clientWidth - 5);

                    leftArrow.style.opacity = isAtStart ? '0.5' : '1';
                    leftArrow.style.pointerEvents = isAtStart ? 'none' : 'auto';

                    rightArrow.style.opacity = isAtEnd ? '0.5' : '1';
                    rightArrow.style.pointerEvents = isAtEnd ? 'none' : 'auto';
                }

                // Initial check
                updateArrows();

                // Update on scroll
                scrollContainer.addEventListener('scroll', updateArrows);
            }
        });
    </script>

    {{-- BAGIAN 4 --}}
    <br><br><br>
    <div class="section-title">
        <h2>VIDEO HIGHLIGHTS</h2>
    </div>

    @if (isset($mainVideo) && $mainVideo)
        <div class="video-highlight">
            <div class="main-video">
                <a href="{{ url('/article/' . $mainVideo->id) }}?autoplay=1" class="slide-link" style="height: 500px;"
                    data-article-id="{{ $mainVideo->id }}">
                    <div class="main-video-img">
                        <!-- Using high-quality thumbnail without YouTube play button -->
                        <img src="https://img.youtube.com/vi/{{ $mainVideo->media->where('type', 'youtube')->first()->path }}/maxresdefault.jpg"
                            alt="{{ $mainVideo->title }}" style="width:100%; height:100%; object-fit:cover;">
                        <!-- Custom play button overlay -->
                        <div class="play-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="main-video-title">{{ $mainVideo->title }}</h3>
                </a>
                <div class="video-description">
                    {{ Str::limit($mainVideo->description, 250) }}
                </div>
            </div>

            <div class="video-list">
                @if (isset($sidebarVideos) && count($sidebarVideos) > 0)
                    @foreach ($sidebarVideos as $video)
                        <div class="video-item">
                            <a href="{{ url('/article/' . $video->id) }}?autoplay=1" class="slide-link"
                                data-article-id="{{ $video->id }}">
                                <div class="video-item-img">
                                    <img src="https://img.youtube.com/vi/{{ $video->media->where('type', 'youtube')->first()->path }}/mqdefault.jpg"
                                        alt="{{ $video->title }}" style="width:100%; height:100%; object-fit:cover;">
                                    <!-- Small play icon overlay -->
                                    <div class="play-overlay-small">
                                        <div class="play-button-small">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="video-item-title">{{ Str::limit($video->title, 100) }}</h4>
                            </a>
                        </div>
                    @endforeach
                @endif

                @if (isset($articlesWithVideos) && count($articlesWithVideos) > 3)
                    <a href="{{ url('/videos') }}" class="more-btn2">Video Lainnya</a>
                @endif
            </div>
        </div>

        <!-- Additional CSS for play button overlays -->
        <style>
            .main-video-img,
            .video-item-img {
                position: relative;
                overflow: hidden;
            }

            /* Shadow and outline styles for videos */
            .video-shadow {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                border: 1px solid rgba(0, 0, 0, 0.08);
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .video-shadow:hover {
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                transform: translateY(-2px);
            }

            .play-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s;
            }

            .main-video-img:hover .play-overlay {
                opacity: 1;
            }

            .play-button {
                width: 80px;
                height: 80px;
                background-color: rgba(201, 21, 110, 0.9);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            }

            .play-button i {
                color: white;
                font-size: 30px;
                margin-left: 5px;
                /* Slight offset to center the play icon */
            }

            .play-overlay-small {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s;
            }

            .video-item-img:hover .play-overlay-small {
                opacity: 1;
            }

            .play-button-small {
                width: 40px;
                height: 40px;
                background-color: rgba(201, 21, 110, 0.9);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            }

            .play-button-small i {
                color: white;
                font-size: 16px;
                margin-left: 2px;
                /* Slight offset to center the play icon */
            }

            /* Fix for the color of the play icon before the title */
            .main-video-title::before,
            .video-item-title::before {
                color: #c4156e;
            }
        </style>
    @else
        <!-- No Videos Available Message -->
        <div style="text-align:center; padding:40px 20px; background:#f8f8f8; border-radius:8px; margin-bottom:30px;">
            <div style="font-size:40px; margin-bottom:20px; color:#ddd;">
                <i class="fas fa-video-slash"></i>
            </div>
            <h4 style="font-size:20px; margin-bottom:10px; color:#666;">No Video Highlights Available</h4>
            <p style="color:#888;">Check back later for new video content.</p>
        </div>
    @endif


@endsection
