@extends('template/mahasiswa')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h2>Edit Surat</h2>
                <form method="POST" action="{{ route('srt_mhw_asn.update', $data->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="thn_awl">Tahun Awal</label>
                        <input type="text" name="thn_awl" value="{{ $data->thn_awl }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="thn_akh">Tahun Akhir</label>
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
                        <label for="nama_ortu">Nama Orang Tua</label>
                        <input type="text" name="nama_ortu" value="{{ $data->nama_ortu }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nip_ortu">NIP Orang Tua</label>
                        <input type="text" name="nip_ortu" value="{{ $data->nip_ortu }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ins_ortu">Instansi Orang Tua</label>
                        <input type="text" name="ins_ortu" value="{{ $data->ins_ortu }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_surat" class="form-label">Alasan ditolak</label>
                        <textarea class="form-control" id="catatan_surat" name="catatan_surat" rows="3" disabled>{{ $data->catatan_surat }}</textarea>
                    </div>
                    <button type="submit">Update</button>
                    <a href="/srt_mhw_asn">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
