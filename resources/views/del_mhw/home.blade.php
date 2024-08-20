@extends('template/soft_delete')
@section('inti_data')
    <title>Akses denied</title>
    <h1>Untuk {{ auth()->user()->nama }}</h1>
    <h1>Akun anda telah di suspend oleh admin, minta ke admin untuk mengembalikan akun anda</h1>
    <a href='/logout' class="btn btn-info">Logout</a>
@endsection
