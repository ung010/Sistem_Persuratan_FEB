@extends('template/mahasiswa')
@section('inti_data')
    <title>Halo {{ auth()->user()->nama }}</title>
    <h1>Haloo {{ auth()->user()->nama }}</h1>
@endsection