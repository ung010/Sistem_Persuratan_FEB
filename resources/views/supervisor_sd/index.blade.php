@extends('supervisor_sd.layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex gap-5 justify-content-center align-items-stretch align-content-center mb-5">
            <div class="card flex-even" style="background-color: #FFC2AF">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Keterangan Masih Kuliah (Bagi ASN)</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $srt_mhw_asn }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
            <div class="card flex-even" style="background-color:#EDEDED">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Keterangan Masih Mahasiswa</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $srt_masih_mhw }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
            <div class="card flex-even" style="background-color:  #BFBFBF">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Ijin Magang</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $srt_magang }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
            <div class="card flex-even" style="background-color: #D1FAF8">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Ijin Penelitian</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $srt_izin_plt }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex gap-5 justify-content-center align-items-stretch align-content-center">
            <div class="card flex-even" style="background-color: #DDE5E9">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Permohonan Pengembalian Biaya Pendidikan</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $srt_pmhn_kmbali_biaya }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
            <div class="card flex-even" style="background-color: #FAEEAF">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Keterangan Bebas Pinjam</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $srt_bbs_pnjm }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
            <div class="card flex-even" style="background-color: #EDEDED">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Legalisir</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $legalisir }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
            <div class="card flex-even" style="background-color: #C7FAB9">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="card-mail">
                        <h4 class="card-title">Surat Selesai</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="card-title">{{ $total_surat }}</h5>
                    </div>
                    <div class="container-fluid">
                        <div class="border-top my-3 border-dark"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <h5 class="m-0 card-title">Jumlah Surat Masuk</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

