@extends('template/admin')
@section('inti_data')

    <head>
        <title>Cek Surat keterangan untuk anak ASN {{ $srt_mhw_asn->nama }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <h4>Nama : {{ $srt_mhw_asn->nama }}</h4>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $srt_mhw_asn->nmr_unik }}</p>
                </div>
                <div class="mb-3">
                    <p>Departemen: {{ $srt_mhw_asn->nama_dpt }}</p>
                </div>
                <div class="mb-3">
                    <p>Prodgam Studi: {{ $srt_mhw_asn->jenjang_prodi }}</p>
                </div>
                <div class="mb-3">
                    <p>Tahun Ajaran: {{ $srt_mhw_asn->thn_awl }} / {{ $srt_mhw_asn->thn_akh }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Asal: {{ $srt_mhw_asn->almt_asl }}</p>
                </div>
                <div class="mb-3">
                    <p>No Whatsapp: {{ $srt_mhw_asn->nowa }}</p>
                </div>
                <div class="mb-3">
                    <p>Email: {{ $srt_mhw_asn->email }}</p>
                </div>
                <div class="mb-3">
                    <p>Nama Orang Tua / Wali: {{ $srt_mhw_asn->nama_ortu }}</p>
                </div>
                <div class="mb-3">
                    <p>NIP / NRP: {{ $srt_mhw_asn->nip_ortu }}</p>
                </div>
                <div class="mb-3">
                    <p>Instansi / Perusahaan: {{ $srt_mhw_asn->ins_ortu }}</p>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if ($srt_mhw_asn->foto)
                        <img src="{{ asset('storage/foto/mahasiswa/' . $user->foto) }}" alt="Foto User"
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
                    <a href='/srt_mhw_asn/admin' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setujuModal" tabindex="-1" aria-labelledby="setujuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_mhw_asn.setuju', $srt_mhw_asn->id) }}" method="POST">
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
                    <form action="{{ route('srt_mhw_asn.tolak', $srt_mhw_asn->id) }}" method="POST">
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
