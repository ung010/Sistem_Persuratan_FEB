<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            @auth
                @if (auth()->user()->status === 'mahasiswa')
                    <a class="nav-link" href="/user">Mahasiswa {{ auth()->user()->nama }}</a>
                @elseif (auth()->user()->status === 'alumni')
                    <a class="nav-link" href="/user">Alumni {{ auth()->user()->nama }}</a>
                @endif
            @endauth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dashboard
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/user/my_account/{{ auth()->user()->id }}">My
                                    Account</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Surat
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/srt_mhw_asn">Surat keterangan untuk anak ASN</a></li>
                            <li><a class="dropdown-item" href="/srt_masih_mhw">Surat Keterangan Masih Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="/srt_magang">Surat Magang</a></li>
                            <li><a class="dropdown-item" href="/srt_izin_plt">Surat Izin Penelitian</a></li>
                            <li><a class="dropdown-item" href="/srt_pmhn_kmbali_biaya">Surat Permohonan Pengembalian
                                    Biaya Pendidikan</a></li>
                            <li><a class="dropdown-item" href="/srt_bbs_pnjm">Surat Bebas Pinjam</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/legalisir">Legalisir</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/survey">
                            Survey
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</head>

<body>
    @include('template/pesan')
    @yield('inti_data')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
