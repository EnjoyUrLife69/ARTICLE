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
                            <span class="slide-tag">Trending</span>
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

    {{-- Article Category section / BAGIAN 3 --}}
    <div class="container">
        <header class="blog-header">
            <nav class="categories-nav">
                <a class="category-link active">CATEGORY</a>
                <a class="category-link">CATEGORY</a>
                <a class="category-link">CATEGORY</a>
                <a class="category-link">CATEGORY</a>
                <button class="more-btn">MORE</button>
            </nav>
            <h1 class="blog-title">LOREM IPSUM</h1>
        </header>

        <div class="blog-content">
            <main class="blog-grid">
                <article class="article-card2">
                    <div class="article-image">IMG</div>
                    <div class="article-date">Date</div>
                    <a href="#" class="article-title">Lorem ipsum dolor sit amet consectetur</a>
                </article>

                <article class="article-card2">
                    <div class="article-image">IMG</div>
                    <div class="article-date">Date</div>
                    <a href="#" class="article-title">Lorem ipsum dolor sit amet consectetur</a>
                </article>

                <article class="article-card2">
                    <div class="article-image">IMG</div>
                    <div class="article-date">Date</div>
                    <a href="#" class="article-title">Lorem ipsum dolor sit amet consectetur</a>
                </article>

                <article class="article-card2">
                    <div class="article-image">IMG</div>
                    <div class="article-date">Date</div>
                    <a href="#" class="article-title">Lorem ipsum dolor sit amet consectetur</a>
                </article>
            </main>

            <aside class="sidebar">
                <h2 class="sidebar-title">CATEGORY</h2>
                <ul class="categories-list">
                    <li>
                        <a href="#">Category 1</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 2</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 3</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 4</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 5</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 6</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 7</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 8</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 9</a>
                        <span class="post-count">(200)</span>
                    </li>
                    <li>
                        <a href="#">Category 10</a>
                        <span class="post-count">(200)</span>
                    </li>
                </ul>
                <button class="sidebar-more">MORE</button>
            </aside>
        </div>

        <div class="loader"></div>
    </div>

    {{-- BAGIAN 4 --}}
    <br><br><br>
    <div class="section-title">
        <h2>VIDEO HIGHLIGHTS</h2>
    </div>

    <div class="video-highlight">
        <div class="main-video">
            <div class="main-video-img"></div>
            <h3 class="main-video-title">Lorem ipsum dolor sit amet consectetur adipisicing elit</h3>
            <div class="video-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam,
                voluptatum.</div>
        </div>

        <div class="video-list">
            <div class="video-item">
                <div class="video-item-img"></div>
                <h4 class="video-item-title">Lorem ipsum dolor sit amet consectetur</h4>
            </div>

            <div class="video-item">
                <div class="video-item-img"></div>
                <h4 class="video-item-title">Lorem ipsum dolor sit amet consectetur</h4>
            </div>

            <button class="more-btn2">Video Lainnya</button>
        </div>
    </div>
@endsection
