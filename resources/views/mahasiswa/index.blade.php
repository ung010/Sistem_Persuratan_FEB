@extends('template/dasar1')
@section('inti_data')
    <title>Halo {{ auth()->user()->nama }}</title>
    <h1>Untuk Mahasiswa {{ auth()->user()->nama }}</h1>
@endsection