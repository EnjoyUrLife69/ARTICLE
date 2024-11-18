@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center>Edit Article's</center>
                    </div>
                </h3>
            </div>
        </div>
        <form action="{{ route('articles.update', $articles->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mt-4">
                <div class="col-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="form-label" style="font-weight: bold">Form</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="basic-default-name"
                                        placeholder="Enter Article title" value="{{ $articles->title }}" />
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-company">Release Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="basic-default-company"
                                            placeholder="ACME Inc." />
                                    </div>
                                </div> --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-email">Categories</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select id="defaultSelect" class="form-select" name="categorie_id">
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('categorie_id', $articles->categorie_id) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categorie_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-text">Choose your category</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                                <div class="col-sm-10">
                                    <textarea style="height: 200%" id="basic-default-message" class="form-control" name="description"
                                        placeholder="Tell More about this article" aria-label="Hi, Do you have a moment to talk Joe?"
                                        aria-describedby="basic-icon-default-message2">{{ $articles->description }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <p style="color: white">.</p>
                            </div>
                            <div class="div" style="float: right">
                                <div class="row mt-3" style="width: 95%">
                                    <div class="col-6">
                                        <a href="{{ route('articles.index') }}"><button type="button"
                                                class="btn btn-danger">Cancel</button></a>
                                    </div>
                                    <div class="col-6">
                                        <button type="cancel" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="max-height: 50px">
                    <div class="card mb-4" style="height: 24.8rem">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="form-label" style="font-weight: bold">Cover</h5>
                        </div>
                        <div class="card-body">
                            <!-- Input file -->
                            <input class="form-control" type="file" id="formFile" name="cover" accept="image/*"
                                onchange="previewImage(); displayFileName();" {{ !$articles->cover ? 'required' : '' }} />
                            @error('cover')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="form-text text-muted">
                                jpeg, png, jpg, gif, svg, webp.
                            </small>

                            <!-- Tempat Preview -->
                            <div id="previewContainer" class="mt-3">
                                <center>
                                    <label for="formFile" style="cursor: pointer;">
                                        <!-- Jika sudah ada gambar, tampilkan gambar tersebut, jika belum tampilkan placeholder -->
                                        <img id="previewImage"
                                            src="{{ $articles->cover ? asset('storage/images/articles/' . $articles->cover) : asset('assets/img/img_placeholder.png') }}"
                                            alt="Preview Image" class="mt-3"
                                            style="max-height: 228px; max-width: 100%; display: block;" />
                                    </label>
                                </center>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row-4">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-message"
                                        style="font-weight: bold">Content</label>
                                    <div class="col-sm-10">
                                        <textarea style="height: 150%" id="exampleFormControlTextarea2" class="form-control" name="content"
                                            placeholder="Write your content here" aria-label="Hi, Do you have a moment to talk Joe?"
                                            aria-describedby="basic-icon-default-message2">{{ $articles->content }}</textarea>
                                        @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endsection
