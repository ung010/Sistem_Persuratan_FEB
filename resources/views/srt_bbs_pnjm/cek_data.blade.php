@extends('template/admin')
@section('inti_data')

    <head>
        <title>Cek Surat Magang {{ $srt_bbs_pnjm->nama_mhw }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <h4>Nama : {{ $srt_bbs_pnjm->nama_mhw }}</h4>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $srt_bbs_pnjm->nmr_unik }}</p>
                </div>               
                <div class="mb-3">
                    <p>Program Studi: {{ $srt_bbs_pnjm->jenjang_prodi }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat di Semarang: {{ $srt_bbs_pnjm->almt_smg }}</p>
                </div>
                <div class="mb-3">
                    <p>No WA: {{ $srt_bbs_pnjm->nowa }}</p>
                </div>
                <div class="mb-3">
                    <p>Dosen Wali: {{ $srt_bbs_pnjm->dosen_wali }}</p>
                </div>
                
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if ($srt_bbs_pnjm->foto)
                        <img src="{{ asset('storage/foto/mahasiswa/' . $srt_bbs_pnjm->foto) }}" alt="Foto User"
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
                    <a href='/srt_bbs_pnjm/admin' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setujuModal" tabindex="-1" aria-labelledby="setujuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_bbs_pnjm.admin_setuju', $srt_bbs_pnjm->id) }}" method="POST">
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
                    <form action="{{ route('srt_bbs_pnjm.admin_tolak', $srt_bbs_pnjm->id) }}" method="POST">
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
