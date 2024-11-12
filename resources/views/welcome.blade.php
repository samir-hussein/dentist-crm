@extends('layouts.auth-layout')

@section('title', 'Login')

@section('content')
    <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('login.submit') }}" method="post">
        @csrf
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="" width="100">
        </a>
        <h1 class="h6 mb-3" style="font-family: 'Sarina', cursive;font-size:25px">NORY DENTAL
            CLINIC</h1>
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
        <p class="mt-5 mb-3 text-muted">2024 © Designed & Developed By <a
                href="https://www.facebook.com/profile.php?id=61566190455839&mibextid=LQQJ4d" target="_blank">Samir
                Hussein</a></p>
    </form>
@endsection
