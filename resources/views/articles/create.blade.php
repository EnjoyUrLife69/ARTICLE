@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid p-0">
                <!-- Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 fw-bold">
                                    <i class="fas fa-pen-to-square me-2"></i>Create Article
                                </h4>
                                <div>
                                    <a href="{{ route('articles.index') }}"
                                        class="btn btn-outline-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <!-- Left Column - Form Fields -->
                    <div class="col-lg-8 col-md-12 mb-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <!-- Title -->
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-medium">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Enter article title" required>
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-4">
                                    <label for="category" class="form-label fw-medium">Category <span
                                            class="text-danger">*</span></label>
                                    <select id="defaultSelect" class="form-select" name="categorie_id" required>
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Choose the most appropriate category</div>
                                    @error('categorie_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-medium">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea id="description" class="form-control" name="description" rows="4"
                                        placeholder="Provide a brief description for this article" required></textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- YouTube Link -->
                                <div class="mb-2">
                                    <label for="youtube-link" class="form-label fw-medium">YouTube Video</label>
                                    <input type="text" class="form-control" id="youtube-link" name="youtube_link"
                                        placeholder="Enter YouTube video URL (optional)">
                                    <div class="form-text">Optional: Add a YouTube video to enhance your article</div>
                                    @error('youtube_link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Content Editor -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Content <span class="text-danger">*</span></h5>
                            </div>
                            <div class="card-body p-0">
                                <textarea id="content-editor" class="form-control border-0" name="content" rows="15"
                                    placeholder="Write your article content here..."></textarea>
                                @error('content')
                                    <small class="text-danger px-3 py-2 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Media -->
                    <div class="col-lg-4 col-md-12">
                        <!-- Cover Image -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Cover Image <span class="text-danger">*</span></h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="cover-image" name="cover"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp"
                                        onchange="previewCoverImage()">
                                    <small class="form-text text-muted d-block mt-1">
                                        Supported formats: jpeg, png, jpg, gif, svg, webp
                                    </small>
                                    @error('cover')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="text-center border rounded p-3 bg-light mt-3">
                                    <img id="cover-preview" src="{{ asset('assets/img/img_placeholder.png') }}"
                                        alt="Cover Preview" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Images -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Additional Images</h5>
                            </div>
                            <div class="card-body">
                                <input class="form-control" type="file" id="additional-images"
                                    name="additional_images[]" multiple
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp"
                                    onchange="previewAdditionalImages()">
                                <small class="form-text text-muted d-block mt-1">
                                    Upload up to 5 additional images to enhance your article
                                </small>
                                @error('additional_images.*')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <!-- Additional Images Preview -->
                                <div id="additional-images-preview" class="row mt-3 g-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            // Cover image preview
            function previewCoverImage() {
                const input = document.getElementById('cover-image');
                const preview = document.getElementById('cover-preview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Additional images preview
            function previewAdditionalImages() {
                const input = document.getElementById('additional-images');
                const previewContainer = document.getElementById('additional-images-preview');

                // Clear previous previews
                previewContainer.innerHTML = '';

                if (input.files) {
                    // Limit to 5 images
                    const filesToProcess = Math.min(input.files.length, 5);

                    for (let i = 0; i < filesToProcess; i++) {
                        const file = input.files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-4';

                            const card = document.createElement('div');
                            card.className = 'card h-100';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'card-img-top';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';

                            card.appendChild(img);
                            col.appendChild(card);
                            previewContainer.appendChild(col);
                        }

                        reader.readAsDataURL(file);
                    }

                    // Warning if more than 5 files were selected
                    if (input.files.length > 5) {
                        const warningDiv = document.createElement('div');
                        warningDiv.className = 'col-12 mt-2';
                        warningDiv.innerHTML =
                            '<div class="alert alert-warning py-2 small">Only the first 5 images will be uploaded.</div>';
                        previewContainer.appendChild(warningDiv);
                    }
                }
            }

            // Initialize any rich text editors or other components here
            document.addEventListener('DOMContentLoaded', function() {
                // Example: If you're using a rich text editor for content
                // Replace with your actual editor initialization code
                if (typeof tinymce !== 'undefined') {
                    tinymce.init({
                        selector: '#content-editor',
                        height: 500,
                        menubar: false,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table paste code help wordcount'
                        ],
                        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                            alignleft aligncenter alignright alignjustify | \
                            bullist numlist outdent indent | removeformat | help'
                    });
                }
            });
        </script>

        <!-- Add the following CSS to your stylesheet -->
        <style>
            /* Form styling */
            .card {
                border-radius: 8px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .card-header {
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .form-control:focus,
            .form-select:focus {
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
            }

            .form-label {
                color: #444;
            }

            /* Make the editor look nicer */
            #content-editor {
                min-height: 300px;
                padding: 1rem;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .card-header h5 {
                    font-size: 1rem;
                }

                #cover-preview {
                    max-height: 150px;
                }
            }
        </style>
    @endsection
