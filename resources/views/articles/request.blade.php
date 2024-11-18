@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px">
                    <div data-aos="flip-left">
                        <center>Article's Request</center>
                    </div>
                </h3>
            </div>
        </div>
        @if (session('success'))
            <script type="text/javascript">
                showToast('Success!', '{{ session('success') }}', 'success');
            </script>
        @endif
        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr style="font-weight: bold">
                                <th>No</th>
                                <th>Writer</th>
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
                                    <td style="font-weight: bold"><center><img src="{{ asset('storage/images/users/' . $data->user->image) }}"
                                            alt="Profile Image" class="img-fluid rounded-circle" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ $data->user->name }}" data-bs-offset="0,4" data-bs-html="true"
                                            style="width: 35px; height: 35px"></center></td>
                                    <td style="font-weight: bold">{{ Str::limit($data->title, 45) }}</td>
                                    <td style="font-weight: bold">
                                        {{ \Carbon\Carbon::parse($data->release_date)->translatedFormat('D ,jS M Y') }}
                                    </td>
                                    <td style="font-weight: bold">{{ $data->categorie->name }}</td>
                                    <td><b
                                            class="badge 
                                    {{ $data->status == 'approved' ? 'bg-label-success' : '' }}
                                    {{ $data->status == 'pending' ? 'bg-label-warning' : '' }}
                                    {{ $data->status == 'rejected' ? 'bg-label-danger' : '' }}"><i
                                                class='bx bx-time-five'></i>
                                            {{ ucfirst($data->status) }} </b>
                                    </td>
                                    <td>
                                        {{-- SHOW --}}
                                        <button type="button" class="btn btn-sm btn-warning"
                                            data-bs-target="#Show-request{{ $data->id }}" data-bs-toggle="modal">
                                            <i class='bx bx-show-alt' data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Show" data-bs-offset="0,4" data-bs-html="true"></i>
                                        </button>
                                        @include('articles.show')


                                        {{-- EDIT
                                        @can('article-edit')
                                            <a href="{{ route('articles.edit', $data->id) }}"><button type="button"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="modal">
                                                    <i class='bx bx-edit' data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit" data-bs-offset="0,4" data-bs-html="true"></i>
                                                </button></a>
                                        @endcan --}}

                                        {{-- DELETE
                                        @can('article-delete')
                                            <form action="{{ route('articles.destroy', $data->id) }}" method="POST"
                                                style="display: inline;" id="deleteForm{{ $data->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                    id="deleteButton{{ $data->id }}" data-bs-offset="0,4"
                                                    data-bs-placement="top" data-bs-html="true" title="<span>Delete</span>">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
