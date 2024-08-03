@extends('template/admin')
@section('inti_data')

    <head>
        <title>Cek Surat Magang {{ $legalisir->nama }}</title>
    </head>

    <body>
        <div class="container py-5">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h1>Verif User</h1>
                <div class="mb-3">
                    <p>Jenis Legalisir : {{ $legalisir->jenis_lgl }}</p>
                </div>
                <div class="mb-3">
                    <p>Keperluan : {{ $legalisir->jenis_lgl }}</p>
                </div>
                <div class="mb-3">
                    <p>Nama : {{ $legalisir->nama }}</p>
                </div>
                <div class="mb-3">
                    <p>NIM: {{ $legalisir->nmr_unik }}</p>
                </div>
                <div class="mb-3">
                    <p>Departemenen: {{ $legalisir->nama_dpt }}</p>
                </div>                
                <div class="mb-3">
                    <p>Program Studi: {{ $legalisir->jenjang_prodi }}</p>
                </div>
                <div class="mb-3">
                    <p>Alamat Asal: {{ $legalisir->almt_asl }}</p>
                </div>
                <div class="mb-3">
                    <p>No WA: {{ $legalisir->nowa }}</p>
                </div>
                <div class="mb-3">
                    <p>Pengambilan: {{ $legalisir->ambil }}</p>
                </div>
                @if ($legalisir->almt_kirim == null)
                    <div class="mb-3">
                        <p>Alamat yang dituju: -</p>
                    </div>
                @else
                    <div class="mb-3">
                        <p>Alamat yang dituju: {{ $legalisir->almt_kirim }}</p>
                    </div>
                @endif
                @if ($legalisir->klh_kirim == null)
                    <div class="mb-3">
                        <p>Kelurahan: -</p>
                    </div>
                @else
                    <div class="mb-3">
                        <p>Kelurahan: {{ $legalisir->klh_kirim }}</p>
                    </div>
                @endif
                @if ($legalisir->kcmt_kirim == null)
                    <div class="mb-3">
                        <p>Kecamatan: -</p>
                    </div>
                @else
                    <div class="mb-3">
                        <p>Kecamatan: {{ $legalisir->kcmt_kirim }}</p>
                    </div>
                @endif
                @if ($legalisir->kota_kirim == null)
                    <div class="mb-3">
                        <p>Kota / Kabupaten: -</p>
                    </div>
                @else
                    <div class="mb-3">
                        <p>Kota / Kabupaten: {{ $legalisir->kota_kirim }}</p>
                    </div>
                @endif
                @if ($legalisir->kdps_kirim == null)
                    <div class="mb-3">
                        <p>Kode Pos: -</p>
                    </div>
                @else
                    <div class="mb-3">
                        <p>Kode Pos: {{ $legalisir->kdps_kirim }}</p>
                    </div>
                @endif
                <li>
                    @if($legalisir->file_ijazah)
                        <a href="{{ url('storage/pdf/legalisir/ijazah/' . $legalisir->file_ijazah) }}" target="_blank">View File Ijazah</a>
                    @else
                        File ijazah tidak ditemukan
                    @endif
                </li>
                <li>
                    @if($legalisir->file_transkrip)
                        <a href="{{ url('storage/pdf/legalisir/transkrip/' . $legalisir->file_transkrip) }}" target="_blank">View File transkrip</a>
                    @else
                        File transkrip tidak ditemukan
                    @endif
                </li>
                <div class="mb-3 d-grid">
                    <form action="{{ route('legalisir_admin.admin_dikirim_ijz_trs_setuju', $legalisir->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Disetujui</button>
                    </form>
                </div>
                <div class="mb-3 d-grid">
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#tolakModal">Ditolak</button>
                </div>
                <div class="mb-3 d-grid">
                    <a href='/legalisir/admin/dikirim/ijz_trs' class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('legalisir_admin.admin_dikirim_ijz_trs_tolak', $legalisir->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="catatan_surat" class="form-label">Alasan Legalisir Ditolak</label>
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
