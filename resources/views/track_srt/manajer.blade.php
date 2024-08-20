@extends('admin.layout')

@section('content')
    <div class="container-fluid p-5">
        <div class="card mx-5">
            <div class="mx-5">
                <div class="card d-inline-block intersection-card">
                    <div class="card-body d-flex gap-2 align-items-center">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="heading-image">
                        <p class="heading-card">Tracking Surat Manajer</p>
                    </div>
                </div>
                <br>
                <div class="card d-inline-block">
                    <div class="card-header d-flex align-items-center gap-2">
                        <a class="btn btn-secondary btn-fixed-sized-one" href="/tracking/sv_akd">Supervisor Akademik</a>
                        <a class="btn btn-secondary btn-fixed-sized-one" href="/tracking/sv_sd">Supervisor Sumber Daya</a>
                        <a class="btn btn-secondary btn-fixed-sized-one" href="/tracking/manajer">Manajer Tata Usaha</a>
                    </div>
                </div>
            </div>
            <div class="card-body my-3">
                <div class="d-flex gap-5 justify-content-center align-items-stretch align-content-center mb-5">
                    <div class="card flex-even" style="background-color: #FFC2AF">
                        <div class="card-body row">
                        <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                <p class="tracking">Surat Keterangan Masih Kuliah (Bagi ASN)</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p>{{ $srt_mhw_asn }}</p>
                            </div>
                            <div class="container-fluid">
                                <div class="border-top my-3 border-dark"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="tracking" class="m-0">Jumlah Surat Masuk</p>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-even" style="background-color:#EDEDED">
                        <div class="card-body row">
                        <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                <p class="tracking">Surat Keterangan Masih Mahasiswa</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p>{{ $srt_masih_mhw }}</p>
                            </div>
                            <div class="container-fluid">
                                <div class="border-top my-3 border-dark"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="tracking" class="m-0">Jumlah Surat Masuk</p>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-even" style="background-color:  #BFBFBF">
                        <div class="card-body row">
                            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                <p class="tracking">Surat Izin Magang</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p>{{ $srt_magang }}</p>
                            </div>
                            <div class="container-fluid">
                                <div class="border-top my-3 border-dark"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="tracking" class="m-0">Jumlah Surat Masuk</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-5 justify-content-center align-items-stretch align-content-center mb-5">
                    <div class="card flex-even" style="background-color: #D1FAF8">
                        <div class="card-body row">
                            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                <p class="tracking">Surat Izin Penelitian</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p>{{ $srt_izin_plt }}</p>
                            </div>
                            <div class="container-fluid">
                                <div class="border-top my-3 border-dark"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="tracking" class="m-0">Jumlah Surat Masuk</p>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-even" style="background-color: #DDE5E9">
                        <div class="card-body row">
                        <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                <p class="tracking">Surat Permohonan Pengembalian Biaya Pendidikan</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p>{{ $srt_pmhn_kmbali_biaya }}</p>
                            </div>
                            <div class="container-fluid">
                                <div class="border-top my-3 border-dark"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="m-0 tracking">Jumlah Surat Masuk</p>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-even" style="background-color: #FAEEAF">
                        <div class="card-body row">
                            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                <p class="tracking">Legalisir</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p>{{ $legalisir }}</p>
                            </div>
                            <div class="container-fluid">
                                <div class="border-top my-3 border-dark"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="m-0 tracking">Jumlah Surat Masuk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endsection
