<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm p-4 bg-dark text-white" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Reset Password</h3>

        <!-- Show validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    id="email" 
                    value="{{ old('email', $request->email) }}" 
                    required 
                    autofocus
                    placeholder="Enter your email"
                >
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    id="password" 
                    required
                    placeholder="Enter new password"
                >
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control" 
                    id="password_confirmation" 
                    required
                    placeholder="Confirm new password"
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none text-primary">Back to Login</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
