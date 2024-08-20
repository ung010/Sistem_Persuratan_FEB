<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        .full-height {
            height: 100vh;
        }

        body {
            background-image: url('{{ asset('asset/embung_feb2 1.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center full-height flex-column gap-3">
    @include('template/pesan')
    <div class="card" style="width: 510px">
        <div class="card-head p-2">
            <img src="{{ asset('asset/new-web-logo-feb 2.png') }}" alt="logo undip" style="width:100%">
        </div>
        <div class="card-body">
            <form action="" class="p-5" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" value="{{ old('email') }}" name="email" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <br>
                <div class="d-flex justify-content-center align-items-center p-3 flex-column">
                    <button type="submit" class="btn btn-warning mb-3">Login</button>
                    <a href="{{ route('register') }}" class="btn btn-warning">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
