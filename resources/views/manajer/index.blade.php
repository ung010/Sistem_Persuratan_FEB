@extends('template/manajer')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Halo {{auth()->user()->nama}}</h1>

        <div class="mt-3">
            <h4>Surat Masih Kuliah: {{ $srt_masih_mhw }}</h4>
            <h4>Surat Keterangan Mahasiswa bagi ASN: {{ $srt_mhw_asn }}</h4>
            <h4>Surat Izin Penelitian: {{ $srt_izin_plt }}</h4>
            <h4>Surat Surat Magang: {{ $srt_magang }}</h4>
            <h4>Surat Permohonan Pengembalian Biaya: {{ $srt_pmhn_kmbali_biaya }}</h4>
            <h4>Legalisir: {{ $legalisir }}</h4>
            <h4>Total Surat Selesai: {{ $total_surat }}</h4>
        </div>
    </div> 
@endsection