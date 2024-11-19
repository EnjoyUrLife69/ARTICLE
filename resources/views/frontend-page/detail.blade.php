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
                            <div class="social-share pt-30">
                                <div class="section-tittle">
                                    <h3 class="mr-20">Comment</h3>
                                </div>

                                <center>
                                    <p class="mt-4"><em>Coming Soon</em></p>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card header">
                                <center><b>ABOUT THIS ARTICLE</b></center>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card header">
                                <em>&nbsp;&nbsp;Written By :</em>
                            </div>
                            <div class="card body">
                                <center><img class="mt-2"
                                        src="{{ asset('storage/images/users/' . $articles->user->image) }}"
                                        alt="Profile Image" style="border-radius: 50%; max-width: 120px">
                                    <h5 class="mt-2">{{ $articles->user->name }}</h5>

                                </center>
                                <table border="0" class="mt-3">
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Release Date</td>
                                        <td>&nbsp;&nbsp;:</td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}</td>
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
                                </table><br>
                                <center><p>&nbsp;&nbsp;"{{ $articles->description }}"</p></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About US End -->
    </main>
@endsection
