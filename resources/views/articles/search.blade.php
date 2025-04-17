@extends('layouts.frontend')

@section('content')
    <style>
        .search-result {
            text-align: center;
            padding: 20px;
        }

        .search-result h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .search-result p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .divider {
            height: 3px;
            width: 80px;
            background-color: #333;
            margin: 10px auto;
            border-radius: 2px;
        }

        /* Not found */
        .no-results-container {
            background-color: white;
            max-width: 500px;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .search-animation {
            position: relative;
            margin: 0 auto;
            width: 100px;
            height: 100px;
        }

        /* Circle animation */
        .search-circle {
            stroke-dasharray: 150;
            stroke-dashoffset: 150;
            animation: circle-animation 1.5s ease forwards, pulse 2s 1.5s infinite alternate;
        }

        /* Line animation */
        .search-line {
            stroke-dasharray: 35;
            stroke-dashoffset: 35;
            animation: line-animation 0.5s ease 0.7s forwards;
        }

        /* Cross animations */
        .search-cross-1 {
            animation: cross-1-animation 0.3s ease 1.3s forwards;
        }

        .search-cross-2 {
            animation: cross-2-animation 0.3s ease 1.3s forwards;
        }

        .empty-title,
        .empty-desc,
        .btn-empty {
            opacity: 0;
            transform: translateY(10px);
            animation: fade-in 0.5s ease 1s forwards;
        }

        .empty-desc {
            animation-delay: 1.2s;
        }

        .btn-empty {
            animation-delay: 1.4s;
        }

        /* Animations */
        @keyframes circle-animation {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes line-animation {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes cross-1-animation {
            to {
                x1: 30;
                y1: 30;
                x2: 50;
                y2: 50;
            }
        }

        @keyframes cross-2-animation {
            to {
                x1: 30;
                y1: 50;
                x2: 50;
                y2: 30;
            }
        }

        @keyframes pulse {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.05);
            }
        }

        @keyframes fade-in {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-dark {
            border-radius: 50px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-dark:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }
    </style>

    <div class="container">
        <!-- Header Pencarian -->
        <div class="search-result">
            <h2>Search Results: "<em>{{ $query }}</em>"</h2>
            <p><b>{{ $articles->total() }}</b> articles found</p>
            <div class="divider"></div>
        </div>

        <!-- Hasil Pencarian -->
        @if ($articles->count() > 0)
            <div class="article-grid">
                @foreach ($articles as $data)
                    <a href="{{ url('/article/' . $data->slug) }}">
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
        @else
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="no-results-container p-5 rounded-3 shadow-sm">
                        <!-- Animated Icon -->
                        <div class="search-animation">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
                                <circle class="search-circle" cx="40" cy="40" r="20" fill="none"
                                    stroke="#333" stroke-width="5" />
                                <line class="search-line" x1="55" y1="55" x2="70" y2="70"
                                    stroke="#333" stroke-width="5" stroke-linecap="round" />
                                <line class="search-cross-1" x1="40" y1="40" x2="40" y2="40"
                                    stroke="#999" stroke-width="5" stroke-linecap="round" />
                                <line class="search-cross-2" x1="40" y1="40" x2="40" y2="40"
                                    stroke="#999" stroke-width="5" stroke-linecap="round" />
                            </svg>
                        </div>

                        <div class="text-center">
                            <h3 class="fw-bold mt-4 empty-title">Not Found</h3>
                            <p class="text-muted empty-desc mt-2">Try a different keyword or check your spelling</p>
                            <a href="{{ url('/') }}" class="btn btn-dark btn-empty">
                                <i class="fas fa-home me-2 mt-3"></i> Back to Home
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $articles->appends(['query' => $query])->links() }}
            </div>
        </div>
    </div>
@endsection
