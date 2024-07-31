@extends('template/admin')
@section('inti_data')

    <head>
        <title>Cek Surat Magang {{ $srt_magang->nama }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <h4>Nama : {{ $srt_magang->nama }}</h4>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $srt_magang->nmr_unik }}</p>
                </div>
                <div class="mb-3">
                    <p>Departemenen: {{ $srt_magang->nama_dpt }}</p>
                </div>                
                <div class="mb-3">
                    <p>Program Studi: {{ $srt_magang->jenjang_prodi }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Di Semarang: {{ $srt_magang->almt_smg }}</p>
                </div>
                <div class="mb-3">
                    <p>IPK: {{ $srt_magang->ipk }}</p>
                </div>
                <div class="mb-3">
                    <p>SKSK: {{ $srt_magang->sksk }}</p>
                </div>
                <div class="mb-3">
                    <p>No WA: {{ $srt_magang->nowa }}</p>
                </div>
                <div class="mb-3">
                    <p>Email: {{ $srt_magang->email }}</p>
                </div>
                <div class="mb-3">
                    <p>Lembaga yang dituju: {{ $srt_magang->nama_lmbg }}</p>
                </div>
                <div class="mb-3">
                    <p>Jabatan Pimpinan yang dituju: {{ $srt_magang->jbt_lmbg }}</p>
                </div>
                <div class="mb-3">
                    <p>Kota/Kabupaten Lembaga: {{ $srt_magang->kota_lmbg }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Lembaga: {{ $srt_magang->almt_lmbg }}</p>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if ($srt_magang->foto)
                        <img src="{{ asset('storage/foto/mahasiswa/' . $srt_magang->foto) }}" alt="Foto User"
                            class="img-thumbnail" width="150">
                    @endif
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#setujuModal">Disetujui</button>
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#tolakModal">Ditolak</button>
                </div>
                <div class="mb-3 d-grid">
                    <a href='/srt_magang/admin' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setujuModal" tabindex="-1" aria-labelledby="setujuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_magang.admin_setuju', $srt_magang->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="no_surat" class="form-label">Nomor Surat</label>
                                <input class="form-control" id="no_surat" name="no_surat"></input>
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

        <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_magang.admin_tolak', $srt_magang->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="catatan_surat" class="form-label">Alasan Surat Ditolak</label>
                                <textarea class="form-control" id="catatan_surat" name="catatan_surat" rows="3"></textarea>
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
    @endsection
