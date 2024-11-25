@extends('layouts.frontend')

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
                            <!-- <p>Rem ipsum dolor sit amet, consectetur adipisicing elit.</p> -->
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
                        <!-- Trending Tittle -->
                        <div class="about-right mb-90">
                            <div class="about-img">
                                <img src="{{ asset('storage/images/articles/' . $articles->cover) }}" alt=""
                                    style="max-width: 48rem; border-radius: 2%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            </div>
                            <div class="section-tittle mb-30 pt-30">
                                <h2>{{ $articles->title }}</h2>
                            </div>
                            <div class="about-prea">
                                <p class="about-pera1 mb-25">{!! $articles->content !!}</p>
                            </div>
                            <hr>
                            <div class="social-share pt-30">
                                <div class="section-tittle">
                                    <h3 class="mr-20">Comment</h3>
                                </div>
                                <div class="comment" class="commentList">
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
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            @foreach ($comments as $data)
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
                            @endforeach
                        </div>
                        <br><br><br><br><br><br><br>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                                    <div class="card header">
                                        <center><b>ABOUT THIS ARTICLE</b></center>
                                    </div>
                                </div>
                                <div class="card mt-2" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                                    <div class="card header">
                                        <em>&nbsp;&nbsp;Written By :</em>
                                    </div>
                                    <div class="card body">
                                        <center>
                                            <img class="mt-2"
                                                src="{{ asset('storage/images/users/' . $articles->user->image) }}"
                                                alt="Profile Image" style="border-radius: 50%; max-width: 120px">
                                            <h5 class="mt-2">{{ $articles->user->name }}</h5>
                                        </center>
                                        <table border="0" class="mt-3">
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Release Date</td>
                                                <td>&nbsp;&nbsp;:</td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Category</td>
                                                <td>&nbsp;&nbsp;:</td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $articles->categorie->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;Description</td>
                                                <td>&nbsp;&nbsp;:</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <center>
                                            <p>&nbsp;&nbsp;"{{ $articles->description }}"</p>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <div class="card" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                                    <div class="card-header">
                                        <center class="mt-2"><h5 style="color: #FF0B0B"><b style="text-transform: uppercase;">Explore more articles</b></h5></center>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($article_trending as $data)
                                    <div class="trand-right-single d-flex mt-3">
                                        <div class="trand-right-img">
                                            <a href="{{ url('/article/' . $data->id) }}"><img src="{{ asset('storage/images/articles/' . $data->cover) }}"
                                                alt="" style="max-width: 8rem; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 4%;"></a>
                                        </div>
                                        <div class="trand-right-cap" style="margin-left: 1rem;">
                                            <span class="color1"><em style="font-size: 12px; text-transform: uppercase;">{{ $data->categorie->name }}</em></span>
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
@endsection
