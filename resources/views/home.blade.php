
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="text-center mt-5">
        
        <h1 class="text-white">Welcome{{ Auth::check() ? ', ' . (Auth::user()->name ?? Auth::user()->username) : '' }}!</h1>
        <p class="lead text-light">
            {{ Auth::check() 
                ? "Glad to see you back. Explore your dashboard or check out the latest updates below." 
                : "Please login or register to access your dashboard and more features." 
            }}
        </p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary mt-3 me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light mt-3">Register</a>
        @endauth
    </div>
@endsection