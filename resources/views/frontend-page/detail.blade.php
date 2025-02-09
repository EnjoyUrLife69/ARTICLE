@extends('layouts.frontend')

@section('styles')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .trand-right-single img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .trand-right-single img:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
        }

        .trand-right-cap em {
            color: #FF5E5E;
        }

        .trand-right-cap h6 {
            height: 3.6rem;
            /* Sesuaikan dengan tinggi teks rata-rata */
            overflow: hidden;
        }

        #content-card {
            background: #ffffff;
            padding: 20px;
            box-shadow: 1px 1px 10px 2px rgba(0, 0, 0, 0.2), 2px 2px 2px 1px rgba(0, 0, 0, 0.19);
        }

        #title-card {
            position: relative;
            background: #ffffff;
            padding: 20px;
            box-shadow: 1px 1px 10px 2px rgba(0, 0, 0, 0.2), 2px 2px 2px 1px rgba(0, 0, 0, 0.19);
            height: 4.4%;
        }

        #disqus_thread {
            margin-top: 20px;
        }

        #disqus_thread-card {
            background: #506172;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            /* Menambahkan shadow lembut */
        }


        .card-header {
            background: rgba(255, 94, 94, 0.8);
            border-bottom: 2px solid #FF3B3B;
        }
    </style>
@endsection
@section('content')
    <main>
        <!-- About US Start -->
        <div class="about-area">
            <div class="container">
                <!-- Hot Aimated News Tittle-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="trending-tittle">
                            <strong>Trending now</strong>
                            <div class="trending-animated">
                                <ul id="js-news" class="js-hidden">
                                    @foreach ($article as $data)
                                        <li class="news-item">{{ $data->title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-3 rounded-lg" id="title-card">
                            <div class="section-tittle mb-30">
                                <h2 style="font-weight: bold;"><b>{{ $articles->title }}</b></h2>
                            </div>
                            <div class="card-footer text-end" style="position: absolute; bottom: 10px; right: 10px;">
                                <span class="me-1"><i class="fas fa-eye"></i>&nbsp; {{ $articles->view_count }}</span>
                            </div>
                        </div>

                        <div class="about-right mb-90">
                            <div class="about-img">
                                <img src="{{ asset('storage/images/articles/' . $articles->cover) }}" alt=""
                                    style="max-width: 48rem; border-radius: 2%; box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);">
                            </div>
                            <div class="card mt-4 rounded-lg" id="content-card">
                                <div class="card-body">
                                    <div class="about-prea">
                                        <p class="about-pera1 mb-15">{!! $articles->content !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="social-share pt-30">
                                <div class="card" id="disqus_thread-card">
                                    {{-- Disqus Comment Section --}}
                                    <div class="card-body rounded-lg" id="disqus_thread"></div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        {{-- Comment --}}
                        <div>
                            {{-- @foreach ($comments as $data)
                                <div class="row">
                                    <div class="col-1">
                                        <img src="{{ asset('storage/images/users/' . $data->user->image) }}" alt="img"
                                            height="50" width="50" style="border-radius: 50%">
                                    </div>
                                    <div class="col-11" style="">
                                        <div class="row">
                                            <div class="col-11">
                                                {{ $data->user->name }}
                                            </div>
                                            @if ($data->user->id === Auth::id())
                                                <div class="col-1 position-relative">
                                                    <i class='bx bx-dots-vertical-rounded' style="cursor: pointer;"
                                                        onclick="toggleDropdown(this)"></i>
                                                    <ul class="custom-dropdown-menu"
                                                        style="display: none; position: absolute; right: 0; margin-top: 5px; background: white; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); z-index: 1000; list-style: none; padding: 0; width: 100px;">
                                                        <li>
                                                            <a class="custom-dropdown-item" href="#"
                                                                style="padding: 10px; display: block; color: black; text-decoration: none;">
                                                                <i class='bx bx-edit-alt'></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="custom-dropdown-item" href="#"
                                                                onclick="deleteItem()"
                                                                style="padding: 10px; display: block; color: red; text-decoration: none;">
                                                                <i class='bx bx-trash'></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p style="font-size: 13px;">{{ $data->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-1">
                                        &nbsp;
                                    </div>
                                    <div class="col-11">
                                        <p>{{ $data->content }}
                                        </p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-1">
                                        &nbsp;
                                    </div>
                                </div>
                            @endforeach --}}
                        </div>
                        <br><br><br><br><br><br><br>
                    </div>

                    <div class="col-lg-4">
                        <div class="row">

                            {{-- About this article --}}
                            <div class="col-lg-12">
                                <div class="card rounded-lg mb-3 border-0"
                                    style="background: linear-gradient(135deg, #FF0B0B, #ff7676); max-width: 100%; margin: auto; border-radius: 9px; box-shadow: 1px 1px 2px 2px rgba(255, 67, 67, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);">
                                    <div class="card-header text-white text-center py-2"
                                        style="font-size: 1rem; font-weight: bold; letter-spacing: 1px; border-radius: 9px;">
                                        ABOUT THIS ARTICLE
                                    </div>
                                </div>
                                <div class="card mt-3 border-0 rounded-lg"
                                    style="background-color: #ffffff; box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-light text-secondary py-2"
                                        style="font-style: italic; font-size: 1rem; font-weight: bold;">
                                        &nbsp;&nbsp;Written By :
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <img class="mt-2 shadow-sm"
                                                src="{{ asset('storage/images/users/' . $articles->user->image) }}"
                                                alt="Profile Image"
                                                style="border-radius: 50%; width: 100px; border: 3px solid #ACB6E5; transition: transform 0.3s ease;">
                                            <h5 class="mt-3" style="font-weight: bold; color: #5A5A5A;">
                                                {{ $articles->user->name }}</h5>
                                        </center>
                                        <table class="table table-borderless mt-4" style="width: 100%; font-size: 0.95rem;">
                                            <tr>
                                                <td class="text-muted"><i class="bx bx-calendar"></i> Release Date:</td>
                                                <td>{{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="bx bx-category"></i> Category:</td>
                                                <td>{{ $articles->categorie->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="bx bx-info-circle"></i> Description:</td>
                                            </tr>
                                        </table>
                                        <center>
                                            <blockquote class="blockquote text-center mt-3"
                                                style="font-size: 1rem; color: #333;">
                                                "{{ $articles->description }}"
                                            </blockquote>
                                        </center>
                                    </div>
                                </div>
                            </div>

                            {{-- Trending Articles --}}
                            <div class="col-lg-12 mt-5">
                                <div class="card shadow-sm rounded-lg mb-4 border-0"
                                    style="background: linear-gradient(135deg, #FF0B0B, #ff7676); max-width: 100%; margin: auto; border-radius: 9px;">
                                    <div class="card-header text-white text-center py-2"
                                        style="font-size: 1rem; font-weight: bold; letter-spacing: 1px; border-radius: 9px;">
                                        EXPLORE MORE ARTICLES
                                    </div>
                                </div>
                                <div class="card mt-3 border-0 rounded-lg"
                                    style="background-color: #ffffff; box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);">
                                    <div class="card-body">
                                        @foreach ($article_trending as $data)
                                            <div class="trand-right-single d-flex mt-3">
                                                <div class="trand-right-img">
                                                    <a href="{{ url('/article/' . $data->id) }}">
                                                        <img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                                            alt=""
                                                            style="max-width: 8rem; box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2); border-radius: 4%;">
                                                    </a>
                                                </div>
                                                <div class="trand-right-cap" style="margin-left: 1rem;">
                                                    <span class="color1">
                                                        <em
                                                            style="font-size: 12px; text-transform: uppercase; color: #FF5E5E;">
                                                            {{ $data->categorie->name }}
                                                        </em>
                                                    </span>
                                                    <h6>
                                                        <a href="{{ url('/article/' . $data->id) }}"
                                                            style="color: inherit; text-decoration: none;"
                                                            onmouseover="this.style.color='red'"
                                                            onmouseout="this.style.color='inherit'">
                                                            {{ $data->title }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About US End -->
    </main>
@endsection

@section('scripts')
    <script>
        function toggleDropdown(element) {
            const dropdownMenu = element.nextElementSibling;

            // Tampilkan atau sembunyikan dropdown
            if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
                dropdownMenu.style.display = "block";
            } else {
                dropdownMenu.style.display = "none";
            }

            // Tutup dropdown lain saat yang ini dibuka
            document.addEventListener('click', function(event) {
                if (!element.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = "none";
                }
            });
        }
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
@endsection

{{-- comment --}}
{{-- <div class="comment" class="commentList">
                                    <form id="commentForm" action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="article_id" value="{{ $articles->id }}">
                                        <div class="form-group">
                                            <textarea name="content" class="form-control mb-10" rows="5" placeholder="Write a comment..."></textarea>
                                            <button id="commentList" type="submit"
                                                class="button button-contactForm boxed-btn"
                                                style="float: right;">Send</button>
                                        </div>
                                    </form>
                                </div> --}}
