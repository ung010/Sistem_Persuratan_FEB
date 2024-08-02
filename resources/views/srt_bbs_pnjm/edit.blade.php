@extends('template/mahasiswa')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h2>Edit Surat</h2>
                <form method="POST" action="{{ route('srt_bbs_pnjm.update', $data->id) }}">
                    @csrf
                    <div>
                        <label for="nama_mhw">Nama Mahasiswa:</label>
                        <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                    </div>
                    <div>
                        <label for="dosen_wali">Dosen Wali:</label>
                        <input type="text" name="dosen_wali" id="dosen_wali" value="{{ $data->dosen_wali }}" required>
                    </div>
                    <div>
                        <label for="almt_smg">Alamat Di Semarang:</label>
                        <input type="text" name="almt_smg" id="almt_smg" value="{{ $data->almt_smg }}" required>
                    </div>
                    <div>
                        <label for="nmr_unik">NIM:</label>
                        <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                    </div>
                    <div>
                        <label for="jenjang_prodi">Program Studi:</label>
                        <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}"
                            readonly>
                    </div>
                    <div>
                        <label for="nowa">Nomor Whatsapp:</label>
                        <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                    </div>
                    <button type="submit">Update</button>
                    <a href="/srt_bbs_pnjm">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
