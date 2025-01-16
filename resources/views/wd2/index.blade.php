@extends('wd2.layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex gap-5 justify-content-center align-items-stretch align-content-center">
            <a href="/srt_pmhn_kmbali_biaya/manajer" class="card flex-even" style="background-color: #DDE5E9; text-decoration: none;">
                <div class="card-body row">
                    <div class="d-flex align-items-center  gap-3 mb-3">
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
            </a>
        </div>
    </div>
@endsection

