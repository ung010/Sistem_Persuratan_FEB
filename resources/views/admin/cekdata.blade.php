@extends('template/admin')
@section('inti_data')

    <head>
        <title>Verif account {{ $user->nama }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <h4>Nama : {{ $user->nama }}</h4>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $user->nmr_unik }}</p>
                </div>
                <div class="mb-3">
                    <p>Tempat Tanggal Lahir: {{ $user->ttl }}</p>
                </div>
                <div class="mb-3">
                    <p>Nama Ibu: {{ $user->nama_ibu }}</p>
                </div>
                <div class="mb-3">
                    <p>Jenjang Pendidikan: {{ $user->nama_jnjg }}</p>
                </div>
                <div class="mb-3">
                    <p>Departemen: {{ $user->nama_dpt }}</p>
                </div>
                <div class="mb-3">
                    <p>Prodgam Studi: {{ $user->jenjang_prodi }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Asal: {{ $user->almt_asl }}</p>
                </div>
                <div class="mb-3">
                    <p>No Whatsapp: {{ $user->nowa }}</p>
                </div>
                <div class="mb-3">
                    @if ($user->role === 'non_mahasiswa')
                        Status: Mahasiswa
                    @elseif($user->role === 'non_alumni')
                        Status: Alumni
                    @endif
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if ($user->foto)
                        <img src="{{ asset('storage/foto/mahasiswa/' . $user->foto) }}" alt="Foto User"
                            class="img-thumbnail" width="150">
                    @endif
                </div>
                <div class="mb-3 d-grid">
                    <form action="{{ route('admin.verifikasi.user', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Disetujui</button>
                    </form>
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#catatanModal">Ditolak</button>
                </div>
                <div class="mb-3 d-grid">
                    <a href='/admin/verif_user' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="catatanModal" tabindex="-1" aria-labelledby="catatanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.catatan', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="catatanModalLabel">Tambah Catatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="catatan_user" class="form-label">Catatan dari admin</label>
                                <textarea class="form-control" id="catatan_user" name="catatan_user" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
@endsection
