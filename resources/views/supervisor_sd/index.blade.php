@extends('template/supervisor_sd')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Halo {{ auth()->user()->nama}}</h1>

        <div class="mt-3">
            <h4>Surat Bebas Pinjam: {{ $srt_bbs_pnjm }}</h4>
            <h4>Surat Permohonan Pengembalian Biaya: {{ $srt_pmhn_kmbali_biaya }}</h4>

            <h4>Total Surat Selesai: {{ $total_surat }}</h4>
        </div>
    </div> 
@endsection