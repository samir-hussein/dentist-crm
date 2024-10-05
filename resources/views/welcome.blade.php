@extends('layouts.auth-layout')

@section('title', 'Login')

@section('content')
    <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('login.submit') }}" method="post">
        @csrf
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                </g>
            </svg>
        </a>
        <h1 class="h6 mb-3">Sign in</h1>
        @session('error')
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endsession
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address"
                required="" autofocus="" name="email">

            @error('email')
                <p style="color:red">* {{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password"
                required="" name="password">
            @error('password')
                <p style="color:red">* {{ $message }}</p>
            @enderror
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="hidden" name="remember" value="0">
                <input type="checkbox" value="1" name="remember">Stay logged in</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Let me in</button>
        <p class="mt-5 mb-3 text-muted">© 2024</p>
    </form>
@endsection
