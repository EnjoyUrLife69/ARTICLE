{{-- Show Modal --}}
<div class="modal fade" id="Show{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header border-bottom pb-2">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/images/users/' . $data->user->image) }}" alt="Profile"
                            class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                        <div class="ms-2">
                            <span class="fw-semibold">{{ $data->user->name }}</span>
                            <div class="text-muted small">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $data->categorie->name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body py-4">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            {{-- Article Title --}}
                            <h4 class="fw-bold mb-4 text-break">{{ $data->title }}</h4>

                            {{-- Media Tabs Navigation --}}
                            @if (
                                $data->media()->where('type', 'youtube')->count() > 0 &&
                                    ($data->media()->where('type', 'image')->count() > 0 || $data->cover))
                                <ul class="nav nav-tabs mb-4" id="mediaPills{{ $data->id }}" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="images-pill{{ $data->id }}"
                                            data-bs-toggle="tab" data-bs-target="#images-tab{{ $data->id }}"
                                            type="button" role="tab" aria-controls="images-tab{{ $data->id }}"
                                            aria-selected="true">
                                            <i class="far fa-images me-1"></i> Gambar
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="video-pill{{ $data->id }}"
                                            data-bs-toggle="tab" data-bs-target="#video-tab{{ $data->id }}"
                                            type="button" role="tab" aria-controls="video-tab{{ $data->id }}"
                                            aria-selected="false">
                                            <i class="far fa-play-circle me-1"></i> Video
                                        </button>
                                    </li>
                                </ul>
                            @endif

                            {{-- Media Content --}}
                            <div class="tab-content mb-4" id="mediaPillsContent{{ $data->id }}">
                                {{-- Images Tab - Always active if no video or only image exists --}}
                                <div class="tab-pane fade show active" id="images-tab{{ $data->id }}"
                                    role="tabpanel" aria-labelledby="images-pill{{ $data->id }}">

                                    {{-- Bootstrap Carousel --}}
                                    <div id="carouselArticle{{ $data->id }}" class="carousel slide carousel-fade"
                                        data-bs-ride="carousel">
                                        {{-- Main Carousel --}}
                                        <div class="carousel-inner rounded-3 shadow-sm">
                                            {{-- Cover Image First --}}
                                            <div class="carousel-item active">
                                                <div class="carousel-image-container bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 350px; overflow: hidden;">
                                                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                                        class="d-block w-100 h-100" style="object-fit: cover;"
                                                        alt="{{ $data->title }}">
                                                </div>
                                            </div>

                                            {{-- Additional Images --}}
                                            @if ($data->media()->where('type', 'image')->count() > 0)
                                                @foreach ($data->media()->where('type', 'image')->get() as $image)
                                                    <div class="carousel-item">
                                                        <div class="carousel-image-container bg-light d-flex align-items-center justify-content-center"
                                                            style="height: 350px; overflow: hidden;">
                                                            <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                                class="d-block w-100 h-100" style="object-fit: cover;"
                                                                alt="Additional image">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        {{-- Only show controls if multiple images --}}
                                        @if ($data->media()->where('type', 'image')->count() > 0)
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselArticle{{ $data->id }}"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselArticle{{ $data->id }}"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>

                                            {{-- Thumbnails Navigation --}}
                                            <div
                                                class="carousel-thumbnails mt-3 d-flex justify-content-center flex-wrap">
                                                <button type="button"
                                                    data-bs-target="#carouselArticle{{ $data->id }}"
                                                    data-bs-slide-to="0"
                                                    class="active thumbnail-item me-2 mb-2 p-0 border-0">
                                                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                                        class="rounded-2"
                                                        style="width: 60px; height: 45px; object-fit: cover;"
                                                        alt="Thumbnail">
                                                </button>
                                                @foreach ($data->media()->where('type', 'image')->get() as $key => $image)
                                                    <button type="button"
                                                        data-bs-target="#carouselArticle{{ $data->id }}"
                                                        data-bs-slide-to="{{ $key + 1 }}"
                                                        class="thumbnail-item me-2 mb-2 p-0 border-0">
                                                        <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                            class="rounded-2"
                                                            style="width: 60px; height: 45px; object-fit: cover;"
                                                            alt="Thumbnail">
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Video Tab --}}
                                @if ($data->media()->where('type', 'youtube')->count() > 0)
                                    <div class="tab-pane fade" id="video-tab{{ $data->id }}" role="tabpanel"
                                        aria-labelledby="video-pill{{ $data->id }}">
                                        <div class="video-container rounded-3 shadow-sm overflow-hidden">
                                            <div class="ratio ratio-16x9">
                                                <iframe
                                                    src="https://www.youtube.com/embed/{{ $data->media()->where('type', 'youtube')->first()->path }}"
                                                    title="{{ $data->title }}"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- If only video and no images --}}
                                @if (
                                    $data->media()->where('type', 'youtube')->count() > 0 &&
                                        !($data->media()->where('type', 'image')->count() > 0 || $data->cover))
                                    <div class="video-container rounded-3 shadow-sm overflow-hidden">
                                        <div class="ratio ratio-16x9">
                                            <iframe
                                                src="https://www.youtube.com/embed/{{ $data->media()->where('type', 'youtube')->first()->path }}"
                                                title="{{ $data->title }}"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Description --}}
                            <div class="modal-description">
                                <p>{{ $data->description }}</p>
                            </div>

                            {{-- Article Content --}}
                            <div class="article-content">
                                {!! $data->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer bg-light">
                <div class="d-flex align-items-center me-auto">
                    <span class="me-3 text-muted"><i class="far fa-eye me-1"></i>{{ $data->view_count }}</span>
                    <span class="me-3 text-muted"><i class="far fa-heart me-1"></i>{{ $data->like_count }}</span>
                    <span class="text-muted"><i class="far fa-share-square me-1"></i>{{ $data->share_count }}</span>
                </div>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- CSS tambahan untuk mencegah overflow --}}
<style>
    /* Styling khusus untuk deskripsi agar tidak overflow */
    #Show{{ $data->id }} .modal-description {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
        border-left: 4px solid #0d6efd;
        margin-bottom: 1.5rem;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        word-break: break-all !important;
        white-space: normal !important;
        overflow: hidden !important;
        max-width: 100% !important;
    }

    #Show{{ $data->id }} .modal-description p {
        margin-bottom: 0 !important;
        font-style: italic;
        max-width: 100% !important;
        overflow-wrap: break-word !important;
        word-wrap: break-word !important;
        word-break: break-all !important;
        white-space: normal !important;
    }

    #Show{{ $data->id }} .modal-body {
        font-size: 1rem;
        line-height: 1.6;
        color: #444;
        overflow-x: hidden !important;
    }

    #Show{{ $data->id }} .article-content {
        overflow-wrap: break-word !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
        hyphens: auto !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }

    #Show{{ $data->id }} .article-content>* {
        max-width: 100% !important;
        overflow-x: hidden !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        white-space: normal !important;
    }

    #Show{{ $data->id }} .article-content p {
        margin-bottom: 1.25rem;
        max-width: 100% !important;
        overflow-wrap: break-word !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
    }

    #Show{{ $data->id }} .article-content h1,
    #Show{{ $data->id }} .article-content h2,
    #Show{{ $data->id }} .article-content h3,
    #Show{{ $data->id }} .article-content h4,
    #Show{{ $data->id }} .article-content h5,
    #Show{{ $data->id }} .article-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        max-width: 100% !important;
        overflow-wrap: break-word !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
    }

    #Show{{ $data->id }} .article-content table {
        width: 100% !important;
        max-width: 100% !important;
        table-layout: auto !important;
        overflow-x: auto !important;
        display: block !important;
        white-space: normal !important;
    }

    #Show{{ $data->id }} .article-content table td,
    #Show{{ $data->id }} .article-content table th {
        word-break: break-word !important;
        white-space: normal !important;
    }

    #Show{{ $data->id }} .article-content pre,
    #Show{{ $data->id }} .article-content code {
        white-space: pre-wrap !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        max-width: 100% !important;
        display: block !important;
        overflow-x: hidden !important;
    }

    #Show{{ $data->id }} .article-content img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 6px !important;
        display: block !important;
    }

    #Show{{ $data->id }} .article-content a {
        word-break: break-word !important;
        overflow-wrap: break-word !important;
    }

    #Show{{ $data->id }} .article-content iframe {
        max-width: 100% !important;
        display: block !important;
    }

    /* Force content to be responsive */
    .force-word-wrap {
        overflow-wrap: break-word !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
        white-space: normal !important;
        hyphens: auto !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
</style>

{{-- Script Show modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Show{{ $data->id }}').addEventListener('shown.bs.modal', function() {
            // Fix untuk deskripsi
            const descriptionElement = document.querySelector(
                '#Show{{ $data->id }} .modal-description p');
            if (descriptionElement) {
                descriptionElement.style.wordBreak = 'break-all';
                descriptionElement.style.overflowWrap = 'break-word';
                descriptionElement.style.wordWrap = 'break-word';
                descriptionElement.style.whiteSpace = 'normal';
                descriptionElement.style.maxWidth = '100%';
                descriptionElement.style.display = 'block';
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Add force-word-wrap class to all article content containers
        const articleContents = document.querySelectorAll('.article-content');
        articleContents.forEach(function(container) {
            container.classList.add('force-word-wrap');

            // Add to all direct children
            const children = container.children;
            for (let i = 0; i < children.length; i++) {
                children[i].classList.add('force-word-wrap');
            }
        });
    });
</script>

{{-- Script Show Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for the modal to be shown
        document.getElementById('Show{{ $data->id }}').addEventListener('shown.bs.modal', function() {
            // Create a new carousel instance
            var myCarousel = new bootstrap.Carousel(document.getElementById(
                'carouselArticle{{ $data->id }}'), {
                interval: 5000, // 5 seconds per slide
                wrap: true, // Continuous cycle
                touch: true // Enable touch swiping
            });

            // Fix any potential horizontal overflow issues
            const articleContent = document.querySelector('#Show{{ $data->id }} .article-content');

            // Process all paragraph and heading elements
            const textElements = articleContent.querySelectorAll(
                'p, h1, h2, h3, h4, h5, h6, span, a, li');
            textElements.forEach(function(element) {
                element.style.maxWidth = '100%';
                element.style.wordWrap = 'break-word';
                element.style.overflowWrap = 'break-word';
                element.style.wordBreak = 'break-word';
                element.style.whiteSpace = 'normal';
                element.classList.add('text-break');
            });

            // Process all tables
            const tables = articleContent.querySelectorAll('table');
            tables.forEach(function(table) {
                // Wrap table in a div with horizontal scroll if needed
                const wrapper = document.createElement('div');
                wrapper.style.width = '100%';
                wrapper.style.maxWidth = '100%';
                wrapper.style.overflowX = 'auto';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);

                // Set table styles
                table.style.maxWidth = '100%';
                table.style.tableLayout = 'auto';
            });

            // Process all images
            const images = articleContent.querySelectorAll('img');
            images.forEach(function(img) {
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                img.style.display = 'block';
            });

            // Process all pre/code elements
            const codeBlocks = articleContent.querySelectorAll('pre, code');
            codeBlocks.forEach(function(block) {
                block.style.whiteSpace = 'pre-wrap';
                block.style.wordWrap = 'break-word';
                block.style.maxWidth = '100%';
                block.style.overflowX = 'hidden';
            });

            // Process any iframes
            const iframes = articleContent.querySelectorAll('iframe');
            iframes.forEach(function(iframe) {
                iframe.style.maxWidth = '100%';
                const wrapper = document.createElement('div');
                wrapper.style.width = '100%';
                wrapper.style.position = 'relative';
                wrapper.classList.add('ratio', 'ratio-16x9');
                iframe.parentNode.insertBefore(wrapper, iframe);
                wrapper.appendChild(iframe);
            });
        });
    });
</script>

{{-- Request Modal --}}
<div class="modal fade" id="Show-request{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header border-bottom pb-2">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/images/users/' . $data->user->image) }}" alt="Profile"
                            class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                        <div class="ms-2">
                            <span class="fw-semibold">{{ $data->user->name }}</span>
                            <div class="text-muted small">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $data->categorie->name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body py-4">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            {{-- Article Title --}}
                            <h4 class="fw-bold mb-4 text-break">{{ $data->title }}</h4>

                            {{-- Media Tabs Navigation --}}
                            @if (
                                $data->media()->where('type', 'youtube')->count() > 0 &&
                                    ($data->media()->where('type', 'image')->count() > 0 || $data->cover))
                                <ul class="nav nav-tabs mb-4" id="mediaPillsRequest{{ $data->id }}"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="images-pill-request{{ $data->id }}"
                                            data-bs-toggle="tab"
                                            data-bs-target="#images-tab-request{{ $data->id }}" type="button"
                                            role="tab" aria-controls="images-tab-request{{ $data->id }}"
                                            aria-selected="true">
                                            <i class="far fa-images me-1"></i> Gambar
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="video-pill-request{{ $data->id }}"
                                            data-bs-toggle="tab"
                                            data-bs-target="#video-tab-request{{ $data->id }}" type="button"
                                            role="tab" aria-controls="video-tab-request{{ $data->id }}"
                                            aria-selected="false">
                                            <i class="far fa-play-circle me-1"></i> Video
                                        </button>
                                    </li>
                                </ul>
                            @endif

                            {{-- Media Content --}}
                            <div class="tab-content mb-4" id="mediaPillsContentRequest{{ $data->id }}">
                                {{-- Images Tab - Always active if no video or only image exists --}}
                                <div class="tab-pane fade show active" id="images-tab-request{{ $data->id }}"
                                    role="tabpanel" aria-labelledby="images-pill-request{{ $data->id }}">

                                    {{-- Bootstrap Carousel --}}
                                    <div id="carouselArticleRequest{{ $data->id }}"
                                        class="carousel slide carousel-fade" data-bs-ride="carousel">
                                        {{-- Main Carousel --}}
                                        <div class="carousel-inner rounded-3 shadow-sm">
                                            {{-- Cover Image First --}}
                                            <div class="carousel-item active">
                                                <div class="carousel-image-container bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 350px; overflow: hidden;">
                                                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                                        class="d-block w-100 h-100" style="object-fit: cover;"
                                                        alt="{{ $data->title }}">
                                                </div>
                                            </div>

                                            {{-- Additional Images --}}
                                            @if ($data->media()->where('type', 'image')->count() > 0)
                                                @foreach ($data->media()->where('type', 'image')->get() as $image)
                                                    <div class="carousel-item">
                                                        <div class="carousel-image-container bg-light d-flex align-items-center justify-content-center"
                                                            style="height: 350px; overflow: hidden;">
                                                            <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                                class="d-block w-100 h-100" style="object-fit: cover;"
                                                                alt="Additional image">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        {{-- Only show controls if multiple images --}}
                                        @if ($data->media()->where('type', 'image')->count() > 0)
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>

                                            {{-- Thumbnails Navigation --}}
                                            <div
                                                class="carousel-thumbnails mt-3 d-flex justify-content-center flex-wrap">
                                                <button type="button"
                                                    data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                                    data-bs-slide-to="0"
                                                    class="active thumbnail-item me-2 mb-2 p-0 border-0">
                                                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                                        class="rounded-2"
                                                        style="width: 60px; height: 45px; object-fit: cover;"
                                                        alt="Thumbnail">
                                                </button>
                                                @foreach ($data->media()->where('type', 'image')->get() as $key => $image)
                                                    <button type="button"
                                                        data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                                        data-bs-slide-to="{{ $key + 1 }}"
                                                        class="thumbnail-item me-2 mb-2 p-0 border-0">
                                                        <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                            class="rounded-2"
                                                            style="width: 60px; height: 45px; object-fit: cover;"
                                                            alt="Thumbnail">
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Video Tab --}}
                                @if ($data->media()->where('type', 'youtube')->count() > 0)
                                    <div class="tab-pane fade" id="video-tab-request{{ $data->id }}"
                                        role="tabpanel" aria-labelledby="video-pill-request{{ $data->id }}">
                                        <div class="video-container rounded-3 shadow-sm overflow-hidden">
                                            <div class="ratio ratio-16x9">
                                                <iframe
                                                    src="https://www.youtube.com/embed/{{ $data->media()->where('type', 'youtube')->first()->path }}"
                                                    title="{{ $data->title }}"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- If only video and no images --}}
                                @if (
                                    $data->media()->where('type', 'youtube')->count() > 0 &&
                                        !($data->media()->where('type', 'image')->count() > 0 || $data->cover))
                                    <div class="video-container rounded-3 shadow-sm overflow-hidden">
                                        <div class="ratio ratio-16x9">
                                            <iframe
                                                src="https://www.youtube.com/embed/{{ $data->media()->where('type', 'youtube')->first()->path }}"
                                                title="{{ $data->title }}"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Description --}}
                            <div class="modal-description">
                                <p>{{ $data->description }}</p>
                            </div>

                            {{-- Article Content --}}
                            <div class="article-content">
                                {!! $data->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer dengan tombol Approve dan Reject --}}
            <div class="modal-footer bg-light">
                <div class="d-flex align-items-center me-auto">
                    <span class="me-3 text-muted"><i class="far fa-eye me-1"></i>{{ $data->view_count }}</span>
                    <span class="me-3 text-muted"><i class="far fa-heart me-1"></i>{{ $data->like_count }}</span>
                    <span class="text-muted"><i class="far fa-share-square me-1"></i>{{ $data->share_count }}</span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" data-bs-target="#modalToggle2"
                        data-bs-toggle="modal" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle me-1"></i> Reject
                    </button>
                    <form action="{{ route('articles.approve', $data->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i> Approve
                        </button>
                    </form>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject yang ditingkatkan --}}
<div class="modal fade" id="modalToggle2" aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel2">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('articles.reject', $data->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')

                <!-- Modal Body -->
                <div class="modal-body">
                    Please provide a <b>Reason</b> for rejecting this article. <br>
                    Your feedback will help the writer understand the issues and improve their <br> content. <br><br>
                    <textarea style="height: 200px" id="basic-default-message" class="form-control" name="review_notes"
                        placeholder="Write your feedback here..." aria-describedby="basic-icon-default-message2"></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <!-- Cancel Button -->
                    <button type="button" class="btn btn-sm btn-primary"
                        data-bs-target="#Show-request{{ $data->id }}" data-bs-toggle="modal"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-sm btn-danger">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Enhanced JavaScript for request modal
    document.addEventListener('DOMContentLoaded', function() {
        // Fix untuk konten request modal saat dibuka
        document.getElementById('Show-request{{ $data->id }}').addEventListener('shown.bs.modal',
            function() {
                // Create a new carousel instance
                var requestCarousel = new bootstrap.Carousel(document.getElementById(
                    'carouselArticleRequest{{ $data->id }}'), {
                    interval: 5000, // 5 seconds per slide
                    wrap: true, // Continuous cycle
                    touch: true // Enable touch swiping
                });

                // Fix untuk deskripsi
                const descriptionElement = document.querySelector(
                    '#Show-request{{ $data->id }} .modal-description p');
                if (descriptionElement) {
                    descriptionElement.style.wordBreak = 'break-all';
                    descriptionElement.style.overflowWrap = 'break-word';
                    descriptionElement.style.wordWrap = 'break-word';
                    descriptionElement.style.whiteSpace = 'normal';
                    descriptionElement.style.maxWidth = '100%';
                    descriptionElement.style.display = 'block';
                }

                // Fix any potential horizontal overflow issues
                const articleContent = document.querySelector(
                    '#Show-request{{ $data->id }} .article-content');
                if (articleContent) {
                    // Process all paragraph and heading elements
                    const textElements = articleContent.querySelectorAll(
                        'p, h1, h2, h3, h4, h5, h6, span, a, li');
                    textElements.forEach(function(element) {
                        element.style.maxWidth = '100%';
                        element.style.wordWrap = 'break-word';
                        element.style.overflowWrap = 'break-word';
                        element.style.wordBreak = 'break-word';
                        element.style.whiteSpace = 'normal';
                        element.classList.add('text-break');
                    });

                    // Process all tables
                    const tables = articleContent.querySelectorAll('table');
                    tables.forEach(function(table) {
                        // Wrap table in a div with horizontal scroll if needed
                        const wrapper = document.createElement('div');
                        wrapper.style.width = '100%';
                        wrapper.style.maxWidth = '100%';
                        wrapper.style.overflowX = 'auto';
                        table.parentNode.insertBefore(wrapper, table);
                        wrapper.appendChild(table);

                        // Set table styles
                        table.style.maxWidth = '100%';
                        table.style.tableLayout = 'auto';
                    });

                    // Process all images
                    const images = articleContent.querySelectorAll('img');
                    images.forEach(function(img) {
                        img.style.maxWidth = '100%';
                        img.style.height = 'auto';
                        img.style.display = 'block';
                    });

                    // Process all pre/code elements
                    const codeBlocks = articleContent.querySelectorAll('pre, code');
                    codeBlocks.forEach(function(block) {
                        block.style.whiteSpace = 'pre-wrap';
                        block.style.wordWrap = 'break-word';
                        block.style.maxWidth = '100%';
                        block.style.overflowX = 'hidden';
                    });

                    // Process any iframes
                    const iframes = articleContent.querySelectorAll('iframe');
                    iframes.forEach(function(iframe) {
                        iframe.style.maxWidth = '100%';
                        const wrapper = document.createElement('div');
                        wrapper.style.width = '100%';
                        wrapper.style.position = 'relative';
                        wrapper.classList.add('ratio', 'ratio-16x9');
                        iframe.parentNode.insertBefore(wrapper, iframe);
                        wrapper.appendChild(iframe);
                    });
                }
            });
    });
</script>
