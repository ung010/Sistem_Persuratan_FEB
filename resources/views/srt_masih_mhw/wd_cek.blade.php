@extends('template/admin')
@section('inti_data')

    <head>
        <title>Cek Surat keterangan untuk anak ASN {{ $srt_masih_mhw->nama }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <h4>Nama : {{ $srt_masih_mhw->nama }}</h4>
                </div>
                <div class="mb-3">
                    <p>Tempat, Tanggal Lahir: {{ $srt_masih_mhw->ttl }}</p>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $srt_masih_mhw->ttl }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Asal: {{ $srt_masih_mhw->ttl }}</p>
                </div>
                <div class="mb-3">
                    <p>Departemen: {{ $srt_masih_mhw->nama_dpt }}</p>
                </div>
                <div class="mb-3">
                    <p>Jenjang Pendidikan: {{ $srt_masih_mhw->nama_jnjg }}</p>
                </div>
                <div class="mb-3">
                    <p>No Whatsapp: {{ $srt_masih_mhw->nowa }}</p>
                </div>
                <div class="mb-3">
                    <p>Alasan Pembuatan Surat: {{ $srt_masih_mhw->tujuan_buat_srt }}</p>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if ($srt_masih_mhw->foto)
                        <img src="{{ asset('storage/foto/mahasiswa/' . $srt_masih_mhw->foto) }}" alt="Foto User"
                            class="img-thumbnail" width="150">
                    @endif
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#setujuwdModal">Disetujui</button>
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#tolakwdModal">Ditolak</button>
                </div>
                <div class="mb-3 d-grid">
                    <a href='/srt_masih_mhw/manajer_wd' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setujuwdModal" tabindex="-1" aria-labelledby="setujuwdModallLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_masih_mhw.wd_setuju', $srt_masih_mhw->id) }}" method="POST">
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

        <div class="modal fade" id="tolakwdModal" tabindex="-1" aria-labelledby="tolakwdModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_masih_mhw.wd_tolak', $srt_masih_mhw->id) }}" method="POST">
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
