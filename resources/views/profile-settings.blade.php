@extends('layouts.main-layout')

@section('title', 'Profile')

@section('style')
    <style>
        @media (max-width: 767.98px) {
            #profileInfo {
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
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
            <div class="my-4">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-3 text-center mb-5">
                            <div class="avatar avatar-xl">
                                <img id="avatarPreview" src="{{ $data->avatar_url }}" alt="..."
                                    class="avatar-img rounded-circle">
                            </div>
                            @error('avatar')
                                <p style="color:red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-7" id="profileInfo">
                                    <h4 class="mb-1">{{ $data->name }}</h4>
                                    <p class="small mb-3">
                                        <span
                                            class="badge badge-dark">{{ $data->is_doctor ? 'Dentist' : ($data->is_admin ? 'Admin' : 'Staff') }}</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Mobile view: Buttons centered, Desktop view: Default -->
                            <div class="row justify-content-center justify-content-md-start">
                                <label for="avatarInput" class="btn btn-info">Change Profile Image</label>
                                <input type="file" name="avatar" id="avatarInput" onchange="previewAvatar(event)"
                                    style="display:none">
                            </div>
                            <div class="row justify-content-center justify-content-md-start">
                                <button type="button" class="btn btn-danger" id="removeProfileImage">Remove Profile
                                    Image</button>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <!-- Form fields -->
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Brown"
                                value="{{ old('name') ?? $data->name }}" name="name">
                            @error('name')
                                <p style="color:red">* {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail4">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail4"
                            placeholder="brown@asher.me" value="{{ old('email') ?? $data->email }}">
                        @error('email')
                            <p style="color:red">* {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCompany5">Phone</label>
                            <input type="text" name="phone" class="form-control" id="inputCompany5"
                                value="{{ old('phone') ?? $data->phone }}">
                            @error('phone')
                                <p style="color:red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState5">Gender</label>
                            <select id="inputState5" name="gender" class="form-control">
                                <option {{ $data->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option {{ $data->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <p style="color:red">* {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <hr class="my-4">
                    <!-- Password fields -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="inputPassword4">Current Password</label>
                                <input type="password" class="form-control" id="inputPassword4" name="current_password">
                                @error('current_password')
                                    <p style="color:red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPassword5">New Password</label>
                                <input type="password" class="form-control" id="inputPassword5" name="new_password">
                                @error('new_password')
                                    <p style="color:red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPassword6">Confirm New Password</label>
                                <input type="password" class="form-control" id="inputPassword6"
                                    name="new_password_confirmation">
                                @error('new_password_confirmation')
                                    <p style="color:red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- JavaScript to handle file input and image preview -->
    <script>
        function previewAvatar(event) {
            var reader = new FileReader();
            var avatarPreview = document.getElementById('avatarPreview');

            reader.onload = function() {
                if (reader.readyState == 2) {
                    avatarPreview.src = reader.result;
                }
            }

            reader.readAsDataURL(event.target.files[0]);
        }

        $('#removeProfileImage').on('click', function(e) {
            e.preventDefault();
            // Optional: Show confirmation before proceeding
            if (!confirm("Are you sure you want to remove your profile image?")) {
                return;
            }

            // Send the AJAX request to remove the profile image
            let url = "{{ route('user.image.delete') }}";
            $.ajax({
                url: url, // The backend route to handle the request
                type: 'delete',
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    // Handle error, e.g., show an error message
                    alert('Failed to remove profile image. Please try again.');
                }
            });
        });
    </script>
@endsection
