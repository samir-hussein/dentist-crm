@extends('layouts.main-layout')

@section('title', 'Doctor')

@section('page-path-prefix', 'SETTINGS > ')

@section('settings-active', 'active-link')

@section('buttons')
    <!-- Search Input and Button -->
    <div class="d-inline-block mr-2">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Search..." value="{{ request('search') }}"
                onkeydown="checkEnter(event)">
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary" onclick="searchDoctors()">
                    <span class="fe fe-search"></span> <!-- Search icon -->
                </button>
            </div>
        </div>
    </div>

    <a href="{{ route('doctors.create') }}">
        <button type="button" class="btn btn-primary">
            <span class="fe fe-plus fe-12 mr-2"></span>Create
        </button>
    </a>

    <a href="{{ route('settings') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        @foreach ($data as $row)
            <div class="col-md-3">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <div class="avatar avatar-lg mt-4">
                            <a href="">
                                <img src="{{ $row->avatar_url }}" alt="..." class="avatar-img rounded-circle">
                            </a>
                        </div>
                        <div class="card-text my-2">
                            <strong class="card-title my-0">{{ $row->name }}</strong>
                            <p class="text-muted mb-0">{{ $row->gender }}</p>
                            <p class="text-muted mb-0">{{ $row->email }}</p>
                            <p><span class="badge badge-light text-muted">{{ $row->phone }}</span></p>
                        </div>
                    </div> <!-- ./card-text -->
                    <div class="card-footer">
                        <div class="row align-items-center justify-content-between">

                            <div class="col-auto">
                                <form action="{{ route('doctors.destroy', ['doctor' => $row->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- /.card-footer -->
                </div>
            </div> <!-- .col -->
        @endforeach
    </div> <!-- .row -->
    <div>
        {{ $data->links('pagination::bootstrap-5') }}
    </div>
@endsection

@section('script')
    <script>
        function searchDoctors() {
            var searchQuery = document.getElementById('searchInput').value;
            // Redirect to the same page with the search query
            window.location.href = '{{ route('doctors.index') }}?search=' + encodeURIComponent(searchQuery);
        }

        function checkEnter(event) {
            // Check if the Enter key (key code 13) was pressed
            if (event.which == 10 || event.which == 13) {
                searchDoctors(); // Call the search function
                event.preventDefault(); // Prevent the default form submission
            }
        }
    </script>
@endsection
