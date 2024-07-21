@extends('template/alumni')
@section('inti_data')
    <title>Halo {{ auth()->user()->nama }}</title>
    <h1>Untuk Alumni {{ auth()->user()->nama }}</h1>
@endsection