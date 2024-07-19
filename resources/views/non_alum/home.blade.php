@extends('template/dasar')
@section('inti_data')
    <title>Akses denied</title>
    <h1>Untuk {{ auth()->user()->nama }}</h1>
    <h1>Anda masih belum punya akses, silahkan hubungi admin untuk menyetujui akses anda</h1>
    <a href='/logout' class="btn btn-info">Logout</a>
    <a href='/non_alum/account' class="btn btn-info">My Account</a>
@endsection