@extends('template/mahasiswa')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h2>Edit Surat</h2>
                <form method="POST" action="{{ route('srt_pmhn_kmbali_biaya.update', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="nama_mhw">Nama Mahasiswa:</label>
                        <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                    </div>
                    <br>
                    <div>
                        <label for="nmr_unik">NIM:</label>
                        <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                    </div>
                    <br>
                    <div>
                        <label for="ttl">Tempat Tanggal Lahir:</label>
                        <input type="text" id="ttl" name="ttl" value="{{ $kota_tanggal_lahir }}" readonly>
                    </div>
                    <br>
                    <div>
                        <label for="nowa">Alamat Asal:</label>
                        <input type="text" id="nowa" name="nowa" value="{{ $user->almt_asl }}" readonly>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="skl" class="form-label">SKL:</label>
                        <input type="file" name="skl" id="skl" class="form-control">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="bukti_bayar" class="form-label">Bukti Bayar:</label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="buku_tabung" class="form-label">Buku Tabungan:</label>
                        <input type="file" name="buku_tabung" id="buku_tabung" class="form-control">
                    </div>
                    <br>
                    <div>
                        <label for="nama_dpt">Departemen:</label>
                        <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}"
                            readonly>
                    </div>
                    <br>
                    <div>
                        <label for="jenjang_prodi">Program Studi:</label>
                        <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}"
                            readonly>
                    </div>
                    <br>
                    <div>
                        <label for="nowa">Nomor Whatsapp:</label>
                        <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="catatan_surat" class="form-label">Alasan ditolak</label>
                        <textarea class="form-control" id="catatan_surat" name="catatan_surat" rows="3" disabled>{{ $data->catatan_surat }}</textarea>
                    </div>
                    <button type="submit">Update</button>
                    <a href="/srt_izin_plt">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
