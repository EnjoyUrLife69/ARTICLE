{{-- Show Modal --}}
<div class="modal fade" id="Show{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header border-0 pb-0">
                <div class="d-flex w-100 align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/images/users/' . $data->user->image) }}" alt="Profile"
                            class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                        <span class="ms-2 fw-medium">{{ $data->user->name }}</span>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <span class="badge bg-primary">{{ $data->categorie->name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body pt-2">
                {{-- Article Title --}}
                <h4 class="fw-bold mb-3">{{ $data->title }}</h4>

                {{-- Release Date --}}
                <p class="text-muted small mb-3">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D, jS F Y') }}
                </p>

                {{-- Media Tabs Navigation --}}
                @if (
                    $data->media()->where('type', 'youtube')->count() > 0 &&
                        ($data->media()->where('type', 'image')->count() > 0 || $data->cover))
                    <ul class="nav nav-pills nav-fill mb-3 custom-nav-pills" id="mediaPills{{ $data->id }}"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-2 py-1" id="images-pill{{ $data->id }}"
                                data-bs-toggle="pill" data-bs-target="#images-tab{{ $data->id }}" type="button"
                                role="tab" aria-controls="images-tab{{ $data->id }}" aria-selected="true">
                                Images
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-2 py-1" id="video-pill{{ $data->id }}" data-bs-toggle="pill"
                                data-bs-target="#video-tab{{ $data->id }}" type="button" role="tab"
                                aria-controls="video-tab{{ $data->id }}" aria-selected="false">
                                Video
                            </button>
                        </li>
                    </ul>
                @endif

                {{-- Media Content --}}
                <div class="tab-content mb-4" id="mediaPillsContent{{ $data->id }}">
                    {{-- Images Tab - Always active if no video or only image exists --}}
                    <div class="tab-pane fade show active" id="images-tab{{ $data->id }}" role="tabpanel"
                        aria-labelledby="images-pill{{ $data->id }}">

                        {{-- Bootstrap Carousel --}}
                        <div id="carouselArticle{{ $data->id }}" class="carousel slide carousel-fade"
                            data-bs-ride="carousel">
                            {{-- Main Carousel --}}
                            <div class="carousel-inner rounded shadow-sm">
                                {{-- Cover Image First --}}
                                <div class="carousel-item active">
                                    <div
                                        class="carousel-image-container bg-light d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                            class="carousel-img" alt="{{ $data->title }}">
                                    </div>
                                </div>

                                {{-- Additional Images --}}
                                @if ($data->media()->where('type', 'image')->count() > 0)
                                    @foreach ($data->media()->where('type', 'image')->get() as $image)
                                        <div class="carousel-item">
                                            <div
                                                class="carousel-image-container bg-light d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                    class="carousel-img" alt="Additional image">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            {{-- Only show controls if multiple images --}}
                            @if ($data->media()->where('type', 'image')->count() > 0)
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselArticle{{ $data->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselArticle{{ $data->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                                {{-- Indicators --}}
                                <div class="carousel-indicators mt-1">
                                    <button type="button" data-bs-target="#carouselArticle{{ $data->id }}"
                                        data-bs-slide-to="0" class="active" aria-current="true"
                                        aria-label="Slide 1"></button>
                                    @for ($i = 1; $i <= $data->media()->where('type', 'image')->count(); $i++)
                                        <button type="button" data-bs-target="#carouselArticle{{ $data->id }}"
                                            data-bs-slide-to="{{ $i }}"
                                            aria-label="Slide {{ $i + 1 }}"></button>
                                    @endfor
                                </div>

                                {{-- Thumbnails Navigation --}}
                                <div class="carousel-thumbnails mt-2 d-flex justify-content-center">
                                    <button type="button" data-bs-target="#carouselArticle{{ $data->id }}"
                                        data-bs-slide-to="0" class="active thumbnail-item me-1">
                                        <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                            alt="Thumbnail">
                                    </button>
                                    @foreach ($data->media()->where('type', 'image')->get() as $key => $image)
                                        <button type="button" data-bs-target="#carouselArticle{{ $data->id }}"
                                            data-bs-slide-to="{{ $key + 1 }}" class="thumbnail-item me-1">
                                            <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
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
                            <div class="video-container rounded shadow-sm overflow-hidden">
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
                        <div class="video-container rounded shadow-sm overflow-hidden">
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
                <div class="mb-4 p-3 bg-light rounded">
                    <p class="mb-0">{{ $data->description }}</p>
                </div>

                {{-- Article Content --}}
                <div class="article-content">
                    {!! $data->content !!}
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer border-top-0">
                <div class="d-flex align-items-center me-auto">
                    <span class="me-3 text-muted small"><i class="far fa-eye me-1"></i>{{ $data->view_count }}</span>
                    <span class="me-3 text-muted small"><i
                            class="far fa-heart me-1"></i>{{ $data->like_count }}</span>
                    <span class="text-muted small"><i
                            class="far fa-share-square me-1"></i>{{ $data->share_count }}</span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Set up the carousel to auto-cycle every 5 seconds
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
        });
    });
</script>

{{-- Request Modal --}}
<div class="modal fade" id="Show-request{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            {{-- Modal Header - Matched with Show modal --}}
            <div class="modal-header border-0 pb-0">
                <div class="d-flex w-100 align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/images/users/' . $data->user->image) }}" alt="Profile"
                            class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                        <span class="ms-2 fw-medium">{{ $data->user->name }}</span>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <span class="badge bg-primary">{{ $data->categorie->name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            {{-- Modal Body - Matched with Show modal --}}
            <div class="modal-body pt-2">
                {{-- Article Title --}}
                <h4 class="fw-bold mb-3">{{ $data->title }}</h4>

                {{-- Release Date --}}
                <p class="text-muted small mb-3">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D, jS F Y') }}
                </p>

                {{-- Media Tabs Navigation --}}
                @if (
                    $data->media()->where('type', 'youtube')->count() > 0 &&
                        ($data->media()->where('type', 'image')->count() > 0 || $data->cover))
                    <ul class="nav nav-pills nav-fill mb-3 custom-nav-pills" id="mediaPillsRequest{{ $data->id }}"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-2 py-1" id="images-pill-request{{ $data->id }}"
                                data-bs-toggle="pill" data-bs-target="#images-tab-request{{ $data->id }}" type="button"
                                role="tab" aria-controls="images-tab-request{{ $data->id }}" aria-selected="true">
                                Images
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-2 py-1" id="video-pill-request{{ $data->id }}" data-bs-toggle="pill"
                                data-bs-target="#video-tab-request{{ $data->id }}" type="button" role="tab"
                                aria-controls="video-tab-request{{ $data->id }}" aria-selected="false">
                                Video
                            </button>
                        </li>
                    </ul>
                @endif

                {{-- Media Content --}}
                <div class="tab-content mb-4" id="mediaPillsContentRequest{{ $data->id }}">
                    {{-- Images Tab - Always active if no video or only image exists --}}
                    <div class="tab-pane fade show active" id="images-tab-request{{ $data->id }}" role="tabpanel"
                        aria-labelledby="images-pill-request{{ $data->id }}">

                        {{-- Bootstrap Carousel --}}
                        <div id="carouselArticleRequest{{ $data->id }}" class="carousel slide carousel-fade"
                            data-bs-ride="carousel">
                            {{-- Main Carousel --}}
                            <div class="carousel-inner rounded shadow-sm">
                                {{-- Cover Image First --}}
                                <div class="carousel-item active">
                                    <div
                                        class="carousel-image-container bg-light d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                            class="carousel-img" alt="{{ $data->title }}">
                                    </div>
                                </div>

                                {{-- Additional Images --}}
                                @if ($data->media()->where('type', 'image')->count() > 0)
                                    @foreach ($data->media()->where('type', 'image')->get() as $image)
                                        <div class="carousel-item">
                                            <div
                                                class="carousel-image-container bg-light d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                    class="carousel-img" alt="Additional image">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            {{-- Only show controls if multiple images --}}
                            @if ($data->media()->where('type', 'image')->count() > 0)
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselArticleRequest{{ $data->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselArticleRequest{{ $data->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                                {{-- Indicators --}}
                                <div class="carousel-indicators mt-1">
                                    <button type="button" data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                        data-bs-slide-to="0" class="active" aria-current="true"
                                        aria-label="Slide 1"></button>
                                    @for ($i = 1; $i <= $data->media()->where('type', 'image')->count(); $i++)
                                        <button type="button" data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                            data-bs-slide-to="{{ $i }}"
                                            aria-label="Slide {{ $i + 1 }}"></button>
                                    @endfor
                                </div>

                                {{-- Thumbnails Navigation --}}
                                <div class="carousel-thumbnails mt-2 d-flex justify-content-center">
                                    <button type="button" data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                        data-bs-slide-to="0" class="active thumbnail-item me-1">
                                        <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                            alt="Thumbnail">
                                    </button>
                                    @foreach ($data->media()->where('type', 'image')->get() as $key => $image)
                                        <button type="button" data-bs-target="#carouselArticleRequest{{ $data->id }}"
                                            data-bs-slide-to="{{ $key + 1 }}" class="thumbnail-item me-1">
                                            <img src="{{ asset('storage/images/articles/additional/' . $image->path) }}"
                                                alt="Thumbnail">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Video Tab --}}
                    @if ($data->media()->where('type', 'youtube')->count() > 0)
                        <div class="tab-pane fade" id="video-tab-request{{ $data->id }}" role="tabpanel"
                            aria-labelledby="video-pill-request{{ $data->id }}">
                            <div class="video-container rounded shadow-sm overflow-hidden">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $data->media()->where('type', 'youtube')->first()->path }}?autoplay=0"
                                        title="{{ $data->title }}"
                                        frameborder="0"
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
                        <div class="video-container rounded shadow-sm overflow-hidden">
                            <div class="ratio ratio-16x9">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $data->media()->where('type', 'youtube')->first()->path }}?autoplay=0"
                                    title="{{ $data->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                <div class="mb-4 p-3 bg-light rounded">
                    <p class="mb-0">{{ $data->description }}</p>
                </div>

                {{-- Article Content --}}
                <div class="article-content">
                    {!! $data->content !!}
                </div>
            </div>

            {{-- Modal Footer - Modified to include approve and reject buttons --}}
            <div class="modal-footer border-top-0">
                <div class="d-flex align-items-center me-auto">
                    <span class="me-3 text-muted small"><i class="far fa-eye me-1"></i>{{ $data->view_count }}</span>
                    <span class="me-3 text-muted small"><i
                            class="far fa-heart me-1"></i>{{ $data->like_count }}</span>
                    <span class="text-muted small"><i
                            class="far fa-share-square me-1"></i>{{ $data->share_count }}</span>
                </div>
                <button type="button" class="btn btn-sm btn-danger" data-bs-target="#modalToggle2"
                    data-bs-toggle="modal" data-bs-dismiss="modal">Reject</button>
                <form action="{{ route('articles.approve', $data->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                </form>
                <button type="button" class="btn btn-sm btn-outline-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject - Keep original --}}
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
        // Wait for the request modal to be shown
        document.getElementById('Show-request{{ $data->id }}').addEventListener('shown.bs.modal', function() {
            // Create a new carousel instance
            var requestCarousel = new bootstrap.Carousel(document.getElementById(
                'carouselArticleRequest{{ $data->id }}'), {
                interval: 5000, // 5 seconds per slide
                wrap: true, // Continuous cycle
                touch: true // Enable touch swiping
            });
            
            // For video tab handling
            var videoTab = document.getElementById('video-pill-request{{ $data->id }}');
            if (videoTab) {
                videoTab.addEventListener('shown.bs.tab', function (e) {
                    // Re-initialize video if needed
                    var videoFrame = document.querySelector('#video-tab-request{{ $data->id }} iframe');
                    if (videoFrame) {
                        // Reload iframe to ensure it works
                        var src = videoFrame.src;
                        videoFrame.src = src;
                    }
                });
            }
        });
    });
</script>
