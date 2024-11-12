@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center>Article's</center>
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
                        Table
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-top-card" aria-controls="navs-pills-top-profile" aria-selected="false">
                        Card
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                        aria-selected="false">
                        Lorem
                    </button>
                </li>
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
                                        <th>Title</th>
                                        <th>Release Date</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($articles as $data)
                                        <tr>
                                            <td style="font-weight: bold">{{ $loop->iteration }}</td>
                                            <td style="font-weight: bold">{{ $data->title }}</td>
                                            <td style="font-weight: bold">
                                                {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D , jS F Y') }}
                                            </td>
                                            <td style="font-weight: bold">{{ $data->categorie->name }}</td>
                                            <td><b
                                                    class="badge rounded-pill
                                    {{ $data->status == 'approved' ? 'bg-success' : '' }}
                                    {{ $data->status == 'pending' ? 'bg-info' : '' }}
                                    {{ $data->status == 'rejected' ? 'bg-danger' : '' }}"><i
                                                        class='bx bx-time-five'></i>
                                                    {{ ucfirst($data->status) }} </b>
                                            </td>
                                            <td>
                                                {{-- SHOW --}}
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-bs-target="#Show{{ $data->id }}" data-bs-toggle="modal">
                                                    <i class='bx bx-show-alt' data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Show" data-bs-offset="0,4"
                                                        data-bs-html="true"></i>
                                                </button>

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

                <!-- Other tab contents can go here -->
                <div class="tab-pane fade" id="navs-pills-top-card" role="tabpanel">
                    <div class="row g-4">
                        @foreach ($articles as $data)
                            <div class="col-md-3 d-flex">
                                <div class="card w-100">
                                    <img src="{{ asset('storage/images/articles/' . $data->cover) }}" class="card-img-top"
                                        alt="Card image" style="height: 200px; object-fit: cover; width: 100%;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $data->title }}</h5>
                                        <p class="card-text flex-grow-1">{{ $data->description }}</p>
                                        <a href="#" class="btn btn-primary mt-auto">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                    <p>Lorem content goes here</p>
                </div>
            </div>
        </div>

    </div>
@endsection
