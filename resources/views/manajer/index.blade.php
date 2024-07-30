@extends('template/manajer')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Untuk Manajer Tata Usaha</h1>
        <a href="/manajer/manage_spv" class="btn btn-primary">Manajemen Supervisor</a>
        <a href="/manajer/account/{{ auth()->user()->id }}" class="btn btn-primary">Edit Account</a>
        <a href="/SuratKetMahasiswa" class="btn btn-primary">Surat Keterangan Mahasiswa</a>

        <div class="mt-3">
            <h4>Surat Masih Kuliah: {{ $srt_masih_mhw }}</h4>
            <h4>Surat Keterangan Mahasiswa bagi ASN: {{ $srt_mhw_asn }}</h4>
        </div>
    </div> 
@endsection