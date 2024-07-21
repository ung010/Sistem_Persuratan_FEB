@extends('template/auth')
@section('inti_data')
<head>
    <title>Login</title>
</head>

<div class="container py-5">
    <div class="w-50 center border rounded px-3 py-3 mx-auto">
        <h1>Login</h1>
        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" value="{{ old('email') }}" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
                </div>
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="mb-3 d-grid">
                <a href='/register' class="btn btn-warning">Register</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Show' : 'Hide';
    });
</script>

@endsection
