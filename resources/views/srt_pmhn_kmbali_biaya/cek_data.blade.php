@extends('template/admin')
@section('inti_data')

    <head>
        <title>Cek Surat Magang {{ $srt_pmhn_kmbali_biaya->nama }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <h4>Nama : {{ $srt_pmhn_kmbali_biaya->nama }}</h4>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $srt_pmhn_kmbali_biaya->nmr_unik }}</p>
                </div>  
                <div class="mb-3">
                    <p>Tempat Tanggal Lahir: {{ $srt_pmhn_kmbali_biaya->ttl }}</p>
                </div>           
                <div class="mb-3">
                    <p>Program Studi: {{ $srt_pmhn_kmbali_biaya->jenjang_prodi }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Asal: {{ $srt_pmhn_kmbali_biaya->almt_asl }}</p>
                </div> 
                <div class="mb-3">
                    <p>No WA: {{ $srt_pmhn_kmbali_biaya->nowa }}</p>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if ($srt_pmhn_kmbali_biaya->foto)
                        <img src="{{ asset('storage/foto/mahasiswa/' . $srt_pmhn_kmbali_biaya->foto) }}" alt="Foto User"
                            class="img-thumbnail" width="150">
                    @endif
                </div>
                <ul>
                    <li>
                        @if($srt_pmhn_kmbali_biaya->skl)
                            <a href="{{ url('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files/' . $srt_pmhn_kmbali_biaya->skl) }}" target="_blank">View SKL</a>
                        @else
                            SKL tidak ditemukan
                        @endif
                    </li>
                    <li>
                        @if($srt_pmhn_kmbali_biaya->bukti_bayar)
                            <a href="{{ url('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files/' . $srt_pmhn_kmbali_biaya->bukti_bayar) }}" target="_blank">View Bukti Bayar</a>
                        @else
                            Bukti Bayar tidak ditemukan
                        @endif
                    </li>
                    <li>
                        @if($srt_pmhn_kmbali_biaya->buku_tabung)
                            <a href="{{ url('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files/' . $srt_pmhn_kmbali_biaya->buku_tabung) }}" target="_blank">View Buku Tabungan</a>
                        @else
                            Buku Tabungan tidak ditemukan
                        @endif
                    </li>
                </ul>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#setujuModal">Disetujui</button>
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#tolakModal">Ditolak</button>
                </div>
                <div class="mb-3 d-grid">
                    <a href='/srt_pmhn_kmbali_biaya/admin' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="setujuModal" tabindex="-1" aria-labelledby="setujuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('srt_pmhn_kmbali_biaya.admin_setuju', $srt_pmhn_kmbali_biaya->id) }}" method="POST">
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
                    <form action="{{ route('srt_pmhn_kmbali_biaya.admin_tolak', $srt_pmhn_kmbali_biaya->id) }}" method="POST">
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
