@extends('layouts.frontend')

@section('content')
    <!-- Slideshow section / BAGIAN 1 -->
    <div class="slideshow-container">
        <div class="slide active">
            <img src="https://picsum.photos/1200/500?random=1" alt="Slide 1">
            <div class="slide-content">
                <h2 class="slide-title">Welcome to Our Platform</h2>
            </div>
        </div>
        <div class="slide">
            <img src="https://picsum.photos/1200/500?random=2" alt="Slide 2">
            <div class="slide-content">
                <h2 class="slide-title">Discover Amazing Content</h2>
            </div>
        </div>
        <div class="slide">
            <img src="https://picsum.photos/1200/500?random=3" alt="Slide 3">
            <div class="slide-content">
                <h2 class="slide-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam impedit,
                    perspiciatis sint at cum voluptate exercitationem eligendi velit odio </h2>
            </div>
        </div>
        <div class="slide">
            <img src="https://picsum.photos/1200/500?random=4" alt="Slide 4">
            <div class="slide-content">
                <h2 class="slide-title">Stay Updated</h2>
            </div>
        </div>
        <div class="slide">
            <img src="https://picsum.photos/1200/500?random=5" alt="Slide 5">
            <div class="slide-content">
                <h2 class="slide-title">Explore More</h2>
            </div>
        </div>

        <div class="slide-nav">
            <button onclick="changeSlide(-1)">&#10094;</button>
            <button onclick="changeSlide(1)">&#10095;</button>
        </div>

        <div class="slide-indicators">
            <div class="indicator active" onclick="goToSlide(0)"></div>
            <div class="indicator" onclick="goToSlide(1)"></div>
            <div class="indicator" onclick="goToSlide(2)"></div>
            <div class="indicator" onclick="goToSlide(3)"></div>
            <div class="indicator" onclick="goToSlide(4)"></div>
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
