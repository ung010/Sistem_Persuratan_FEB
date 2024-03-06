@extends('template/dasar1')
@section('inti_data')
    <title>Account {{ auth()->user()->nama }}</title>
    <h1>{{ $user->nama }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>NIM: {{ $user->nim }}</p>
    <p>Tempat Tanggal Lahir: {{ $user->ttl }}</p>
    <p>No Handphone: {{ $user->nowa }}</p>
    <p>Alamat Asal: {{ $user->almt_asl }}</p>
    <p>Alamat di Semarang: {{ $user->almt_smg }}</p>
    <p>Departemen: {{ $user->nama_dpt }}</p>
    <p>Prodi: {{ $user->nama_prd }}</p>
    <a href="/mahasiswa">Kembali</a>
@endsection
