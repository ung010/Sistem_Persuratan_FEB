<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajer Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="sidebar">
        <div class="d-flex flex-column justify-content-between h-100">
            <div class="">
                <img src="{{ asset('asset/new-web-logo-feb 1.png') }}" alt="logo" class="w-100 mb-2">
                <div class="d-flex justify-content-center align-items-center">
                    <h5>MANAJEMEN SURAT</h5>
                </div>
                <ul class="list-unstyled ps-0">
                    <li class="border-top my-3 border-dark"></li>
                    <li class="mb-1">
                        <a href="/manajer" class="link-dark"><img src="{{ asset('asset/icons/admin.png') }}"
                                alt="Icon" style="height: 16px;"> {{ auth()->user()->nama }}</a>
                    </li>
                    <li class="border-top my-3 border-dark"></li>
                    <li class="mb-1">
                        <a href="/manajer" class="link-dark"><img src="{{ asset('asset/icons/dashboard.png') }}"
                                alt="Icon" style="height: 16px;"> Dashboard</a>
                    </li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed p-0 link-dark"
                            data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false"><img
                                src="{{ asset('asset/icons/mail.png') }}" alt="Icon" style="height: 16px;">
                            Manajemen
                            Surat
                        </button>
                        <div class="collapse" id="orders-collapse" style="margin-left: 20px">
                            <div class="d-flex flex-column gap-1 ml-2">
                                <a href="/srt_mhw_asn/manajer" class="link-dark rounded">Keterangan Masih Kuliah (Bagi
                                    ASN)</a>
                                <a href="/srt_masih_mhw/manajer" class="link-dark rounded">Keterangan Masih
                                    Mahasiswa</a>
                                <a href="/srt_magang/manajer" class="link-dark rounded">Izin Magang</a>
                                <a href="/srt_izin_plt/manajer" class="link-dark rounded">Izin Penelitian</a>
                                <a href="/srt_pmhn_kmbali_biaya/manajer" class="link-dark rounded">Permohonan
                                    Pengembalian
                                    Biaya
                                    Pendidikan</a>
                                <a href="/legalisir/manajer/ditempat/ijazah" class="link-dark rounded">Legalisir Diambil
                                    di Tempat</a>
                                <a href="/legalisir/manajer/dikirim/ijazah" class="link-dark rounded">Legalisir
                                    Dikirim</a>
                            </div>
                        </div>
                    </li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed p-0 link-dark"
                            data-bs-toggle="collapse" data-bs-target="#orders-collapse-riwayat"
                            aria-expanded="false"><img src="{{ asset('asset/icons/mail.png') }}" alt="Icon"
                                style="height: 16px;"> Riwayat
                            Surat</button>

                        <div class="collapse" id="orders-collapse-riwayat" style="margin-left: 20px">
                            <div class="d-flex flex-column gap-1 ml-2">
                                <a href="/riwayat_srt/manajer/srt_mhw_asn" class="link-dark rounded">Keterangan Masih Kuliah (Bagi
                                ASN)</a>
                                <a href="/riwayat_srt/manajer/srt_masih_mhw" class="link-dark rounded">Keterangan Masih
                                Mahasiswa</a>
                                <a href="/riwayat_srt/manajer/srt_magang" class="link-dark rounded">Izin Magang</a>
                                <a href="/riwayat_srt/manajer/srt_izin_plt" class="link-dark rounded">Izin Penelitian</a>
                                <a href="/riwayat_srt/manajer/srt_pmhn_kmbali_biaya" class="link-dark rounded">Permohonan
                                    Pengembalian Biaya Pendidikan</a>
                                <a href="/riwayat_srt/manajer/legalisir" class="link-dark rounded">Legalisir</a>
                            </div>
                        </div>
                    </li>
                    <li class="mb-1">
                        <a href="/manajer/manage_spv" class="link-dark"><img src="{{ asset('asset/icons/user.png') }}"
                                alt="Icon" style="height: 16px;"> Manajemen Supervisor</a>
                    </li>
                    <li class="mb-1">
                        <a href="/survey/manajer" class="link-dark"><img src="{{ asset('asset/icons/survey.png') }}"
                                alt="Icon" style="height: 16px;"> Survey
                            Kepuasan</a>
                    </li>
                </ul>
            </div>
            <ul class="list-unstyled ps-0">
                <li class="mb-5">
                    <a href="/logout" class="link-dark"><i class="fa fa-power-off" aria-hidden="true"></i> Log
                        Out</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content d-flex justify-content-center align-items-center align-content-center flex-column">
        @include('template/pesan')
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @yield('script')
</body>

</html>
