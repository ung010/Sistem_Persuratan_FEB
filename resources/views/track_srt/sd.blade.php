@extends('template/admin')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <a class="btn btn-primary" href="/tracking/manajer">Manajer</a>
        <a class="btn btn-primary" href="/tracking/sv_akd">Supervisor Akademik</a>
        <a class="btn btn-primary" href="/tracking/sv_sd">Supervisor Sumber Daya</a>
        
        <div class="mt-3">
            <h4>Surat Bebas Pinjam: {{ $srt_bbs_pnjm }}</h4>
            <h4>Surat Permohonan Pengembalian Biaya: {{ $srt_pmhn_kmbali_biaya }}</h4>
        </div>
    </div>
@endsection