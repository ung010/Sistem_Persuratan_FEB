@extends('template/mahasiswa')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h2>Edit Surat</h2>
                <form method="POST" action="{{ route('srt_masih_mhw.update', $data->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_mhw">Nama Mahasiswa:</label>
                        <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nmr_unik">NIM:</label>
                        <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_dpt">Departemen:</label>
                        <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_jnjg">Jenjang Pendidikan:</label>
                        <input type="text" id="nama_jnjg" name="nama_jnjg" value="{{ $jenjang->nama_jnjg }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="kota_tanggal_lahir">Tempat Tanggal Lahir:</label>
                        <input type="text" id="kota_tanggal_lahir" name="kota_tanggal_lahir" value="{{ $kota_tanggal_lahir }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="thn_awl">Tahun Ajaran (Awal)</label>
                        <input type="text" name="thn_awl" value="{{ $data->thn_awl }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="thn_akh">Tahun Ajaran (Akhir)</label>
                        <input type="text" name="thn_akh" value="{{ $data->thn_akh }}" required>
                    </div>
                    <div>
                        <label for="semester">Semester:</label>
                        <select name="semester" id="semester" required>
                            @for ($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" {{ $data->semester == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="almt_smg">Alamat Semarang</label>
                        <input type="text" name="almt_smg" value="{{ $data->almt_smg }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tujuan_buat_srt">Tujuan Pembuatan Surat</label>
                        <input type="text" name="tujuan_buat_srt" value="{{ $data->tujuan_buat_srt }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nowa">No Whatsapp</label>
                        <input type="text" name="nowa" value="{{ $user->nowa }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_surat" class="form-label">Alasan ditolak</label>
                        <textarea class="form-control" id="catatan_surat" name="catatan_surat" rows="3" disabled>{{ $data->catatan_surat }}</textarea>
                    </div>
                    <button type="submit">Update</button>
                    <a href="/srt_masih_mhw">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
