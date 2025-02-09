@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h3 style="font-weight: bold; font-size: 30px;">
                    <div data-aos="flip-left">
                        <center class="mt-2">
                            <i class='bx bxs-category'
                                style="font-size: 31px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"></i>
                            <em style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);"> Categories </em>
                        </center>
                    </div>
                </h3>
            </div>
        </div>
        <div class="card mt-4">
            <div class="row" style="margin-top: 10px;">
                <div class="col-10">
                    <h5 class="card-header">Data Table / Categories</h5>
                </div>
                {{-- CREATE DATA --}}
                <div class="col-2">
                    <div class="mt-3">
                        <!-- Button trigger modal -->
                        @can('categorie-create')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                <i class='bx bx-plus-circle'></i> Add Data
                            </button>
                        @endcan
                        {{-- Create Modal --}}
                        @include('categories.modal-create')
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
                                <th>Name</th>
                                <th style="width: 45%">Description</th>
                                <th style="width: 20%">Used in</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($categories as $data)
                                <tr style="font-weight: bold">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ Str::limit($data->description, 50, '...') }}</td>
                                    <td><b style="color: #696CFF;">{{ $data->articles_count }}</b>&nbsp; Articles Related
                                    </td>
                                    <td>
                                        {{-- SHOW --}}
                                        <button type="button" class="btn btn-sm btn-warning"
                                            data-bs-target="#Show{{ $data->id }}" data-bs-toggle="modal">
                                            <i class='bx bx-show-alt' data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Show" data-bs-offset="0,4" data-bs-html="true"></i>
                                        </button>

                                        {{-- EDIT --}}
                                        @can('categorie-edit')
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-bs-target="#Edit{{ $data->id }}" data-bs-toggle="modal">
                                                <i class='bx bx-edit' data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit" data-bs-offset="0,4" data-bs-html="true"></i>
                                            </button>
                                        @endcan

                                        {{-- DELETE --}}
                                        @can('categorie-delete')
                                            @if ($data->articles_count == 0)
                                                <form action="{{ route('categories.destroy', $data->id) }}" method="POST"
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
                                            @endif
                                        @endcan


                                        {{-- MODAL --}}
                                        @include('categories.modal')
                                    </td>
                                    @if (session('success'))
                                        <script type="text/javascript">
                                            showToast('Success!', '{{ session('success') }}', 'success');
                                        </script>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
