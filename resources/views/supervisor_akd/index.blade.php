@extends('template/supervisor_akd')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Halo {{ auth()->user()->nama}}</h1>
    </div> 
@endsection