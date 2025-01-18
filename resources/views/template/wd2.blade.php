<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        /* Style for the submenu */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
    </style>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/wd2">{{ auth()->user()->nama }}</a>
                        </li>
                    @endauth
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Manajemen Surat
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/srt_pmhn_kmbali_biaya/wd2">Surat Permohonan
                                    Pengembalian Biaya Pendidikan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/wd2/account">
                            Edit Akun
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Riwayat Surat
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/riwayat_srt/wd2/srt_pmhn_kmbali_biaya">Surat Permohonan
                                    Pengembalian Biaya Pendidikan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/survey/wd2">
                            Survey
                        </a>
                    </li>
                </ul>
                <a class="navbar-brand" href="/logout">Logout</a>
            </div>
        </div>
    </nav>
</head>

<body style="background-image: url('https://cdn.crispedge.com/fffe7a.png')">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="container py-6">
        @include('template/pesan')
        @yield('inti_data')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var dropdownSubmenus = document.querySelectorAll('.dropdown-submenu');

                dropdownSubmenus.forEach(function (submenu) {
                    submenu.addEventListener('mouseover', function () {
                        this.querySelector('.dropdown-menu').classList.add('show');
                    });

                    submenu.addEventListener('mouseleave', function () {
                        this.querySelector('.dropdown-menu').classList.remove('show');
                    });
                });
            });
        </script>
    </div>
</body>

</html>
