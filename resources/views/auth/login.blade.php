<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- ✅ Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center " style="min-height: 100vh;">
    <div class="card shadow-sm p-4 bg-dark" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4 text-white">Login</h3>

        <!-- Show validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">

                <label for="email" class="form-label">Email address</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    id="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="Enter your email"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    id="password" 
                    required
                    placeholder="Enter your password"
                >
            </div>

            <!-- <div class="mb-3 form-check">
                <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="remember" 
                    name="remember"
                >
                <a href="register"></a>
                <label class="form-check-label" for="remember">Remember me</label>
            </div> -->
             
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div>
        <div class="text-center mt-2">
            <span class="text-white">Don't have an account? </span>
            <a href="{{ route('register') }}" class="text-primary">Register</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional for features like dropdowns, modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
