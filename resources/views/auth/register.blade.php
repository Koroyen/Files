
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- ✅ Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm p-4 bg-dark" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4 text-white">Register</h3>

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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input 
                    id="username" 
                    type="text" 
                    name="username" 
                    class="form-control" 
                    required 
                    autofocus
                    placeholder="Enter your username"
                    value="{{ old('username') }}"
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    required 
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    required 
                    placeholder="Enter your password"
                >
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control" 
                    required 
                    placeholder="Confirm your password"
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            <span class="text-white">Already have an account? </span>
            <a href="{{ route('login') }}" class="text-primary">Login</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
