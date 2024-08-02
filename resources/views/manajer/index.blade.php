@extends('template/manajer')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Halo {{auth()->user()->nama}}</h1>

        <div class="mt-3">
            <h4>Surat Masih Kuliah: {{ $srt_masih_mhw }}</h4>
            <h4>Surat Keterangan Mahasiswa bagi ASN: {{ $srt_mhw_asn }}</h4>
        </div>
    </div> 
@endsection