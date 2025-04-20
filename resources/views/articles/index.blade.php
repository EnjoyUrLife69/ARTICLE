@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bxs-book-content'
                                style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Article </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>
        @if (session('success'))
            <script type="text/javascript">
                showToast('Success!', '{{ session('success') }}', 'success');
            </script>
        @endif
        <div class="nav-align-top mt-4">

            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                        Detail
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link " role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-top-card" aria-controls="navs-pills-top-profile" aria-selected="true">
                        Card
                    </button>
                </li>


                {{-- <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                        aria-selected="false">
                        Lorem
                    </button>
                </li> --}}
            </ul>

            <div class="card mt-4 tab-content" id="navs-pills-top-table">
                <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                    <!-- Table content goes here -->
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-10">
                            <h5 class="card-header">Data Table / Article</h5>
                        </div>
                        {{-- CREATE DATA --}}
                        <div class="col-2">
                            <div class="mt-3">
                                @can('article-create')
                                    <a href="{{ route('articles.create') }}">
                                        <button type="button" class="btn btn-primary">
                                            <i class='bx bx-plus-circle'></i> Write Article
                                        </button>
                                    </a>
                                @endcan
                            </div>
                        </div>
                        {{-- END CREATE DATA --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr style="font-weight: bold">
                                        <th>No</th>
                                        @if (auth()->user()->hasRole('Super Admin'))
                                            <th>Writer</th>
                                        @endif
                                        <th style="padding-left: 50px;">Title</th>
                                        <th>Category</th>
                                        <th>Release Date</th>
                                        @if (auth()->user()->hasRole('Writer'))
                                            <th>Status</th>
                                        @endif
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($articles as $data)
                                        <tr>
                                            <td style="font-weight: bold">{{ $loop->iteration }}</td>
                                            @if (auth()->user()->hasRole('Super Admin'))
                                                <td style="font-weight: bold"><img
                                                        src="{{ asset('storage/images/users/' . $data->user->image) }}"
                                                        alt="Profile Image" class="img-fluid rounded-circle"
                                                        data-bs-toggle="tooltip"
                                                        style="width: 40px; height: 40px">&nbsp;&nbsp;&nbsp;{{ $data->user->name }}
                                                </td>
                                            @endif
                                            <td style="font-weight: bold; padding-left: 50px;">
                                                {{ Str::limit($data->title, 35) }}</td>
                                            <td style="font-weight: bold">{{ $data->categorie->name }}</td>
                                            <td style="font-weight: bold">
                                                {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}
                                            </td>
                                            @if (auth()->user()->hasRole('Writer'))
                                                <td>
                                                    <b
                                                        class="badge 
                                                        {{ $data->status == 'approved' ? 'bg-success' : '' }}
                                                        {{ $data->status == 'pending' ? 'bg-warning' : '' }}
                                                        {{ $data->status == 'rejected' ? 'bg-danger' : '' }}">
                                                        <i
                                                            class="{{ $data->status == 'approved' ? 'bx bx-check-double' : '' }}
                                                               {{ $data->status == 'pending' ? 'bx bx-time-five' : '' }}
                                                               {{ $data->status == 'rejected' ? 'bx bxs-message-square-x' : '' }}">
                                                        </i>
                                                        {{ ucfirst($data->status) }}
                                                    </b>
                                                </td>
                                            @endif
                                            <td>
                                                {{-- SHOW --}}
                                                {{-- Show Button --}}
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-bs-target="#Show{{ $data->id }}" data-bs-toggle="modal">
                                                    <i class='bx bx-show-alt' data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Show" data-bs-offset="0,4"
                                                        data-bs-html="true"></i>
                                                </button>
                                                @include('articles.show')

                                                {{-- EDIT --}}
                                                @can('article-edit')
                                                    <a href="{{ route('articles.edit', $data->id) }}"><button type="button"
                                                            class="btn btn-sm btn-primary" data-bs-toggle="modal">
                                                            <i class='bx bx-edit' data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit" data-bs-offset="0,4"
                                                                data-bs-html="true"></i>
                                                        </button></a>
                                                @endcan

                                                {{-- DELETE --}}
                                                @can('article-delete')
                                                    <form action="{{ route('articles.destroy', $data->id) }}" method="POST"
                                                        style="display: inline;" id="deleteForm{{ $data->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="tooltip" id="deleteButton{{ $data->id }}"
                                                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                            title="<span>Delete</span>">
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="navs-pills-top-card" role="tabpanel">
                    <div class="row g-4">
                        @foreach ($articles as $data)
                            <div class="col-md-4 d-flex">
                                <div class="card w-100" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                    <!-- Wrapper for image and category -->
                                    <div class="position-relative">
                                        <!-- Category placed on top right of the image -->
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-2"
                                            style="z-index: 10;">{{ $data->categorie->name }}</span>

                                        <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                            class="card-img-top" alt="Card image"
                                            style="height: 200px; object-fit: cover; width: 100%;">
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $data->title }}</h5>
                                        <p class="card-text flex-grow-1">{{ Str::limit($data->description, 99) }}</p>
                                        <a href="{{ url('/article/' . $data->slug) }}" class="btn btn-primary mt-auto">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- <div class="tab-panefade" id="navs-pills-top-messages" role="tabpanel">
                    <p>Lorem content goes here</p>
                </div> --}}
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure $data->id exists or fallback to 0
            var dataId = {{ isset($data) && $data->id ? $data->id : 0 }};

            if (dataId !== 0) { // Only proceed if $data->id is valid
                // Wait for the modal to be shown
                var modalElement = document.getElementById('Show' + dataId);
                if (modalElement) {
                    modalElement.addEventListener('shown.bs.modal', function() {
                        // Initialize thumbnail swiper
                        var thumbsSwiper = new Swiper('#thumbSwiper' + dataId, {
                            spaceBetween: 10,
                            slidesPerView: 4,
                            freeMode: true,
                            watchSlidesProgress: true,
                            breakpoints: {
                                576: {
                                    slidesPerView: 5,
                                },
                                768: {
                                    slidesPerView: 6,
                                }
                            }
                        });

                        // Initialize main swiper
                        var mainSwiper = new Swiper('#imageSwiper' + dataId, {
                            spaceBetween: 0,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            thumbs: {
                                swiper: thumbsSwiper
                            },
                            effect: 'fade',
                            fadeEffect: {
                                crossFade: true
                            },
                            autoplay: {
                                delay: 5000,
                                disableOnInteraction: false,
                            }
                        });
                    });
                }
            }
        });
    </script>
@endsection
