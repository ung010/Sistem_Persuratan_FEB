@extends('template/dasar2')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Untuk Admin</h1>
        <a href="/admin/user" class="btn btn-primary">Manajemen User</a>
        <a href="/admin/verif_user" class="btn btn-primary">Verifikasi User</a>
        <a href="/SuratKetMahasiswa" class="btn btn-primary">Surat Keterangan Mahasiswa</a>
    </div> 
@endsection