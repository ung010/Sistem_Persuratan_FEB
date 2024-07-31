@extends('template/mahasiswa')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h2>Edit Surat</h2>
                <form method="POST" action="{{ route('srt_magang.update', $data->id) }}">
                    @csrf
                    <div>
                        <label for="nama_mhw">Nama Mahasiswa:</label>
                        <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                    </div>
                    <div>
                        <label for="nmr_unik">NIM:</label>
                        <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                    </div>
                    <div>
                        <label for="nama_dpt">Departemen:</label>
                        <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}" readonly>
                    </div>
                    <div>
                        <label for="jenjang_prodi">Jenjang Pendidikan:</label>
                        <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}" readonly>
                    </div>
                    <div>
                        <label for="nowa">Nomor Whatsapp:</label>
                        <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div>
                            <label for="almt_smg">Alamat Semarang:</label>
                            <input type="text" id="almt_smg" name="almt_smg" id="almt_smg" value="{{$data->almt_smg}}">
                        </div>
                        <div>
                            <label for="semester">Semester:</label>
                            <select name="semester" id="semester" required>
                                @for ($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ $data->semester == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="ipk">IPK:</label>
                            <input type="string" name="ipk" id="ipk" value="{{$data->ipk}}" required>
                        </div>
                        <div>
                            <label for="sksk">SKSK:</label>
                            <input type="number" name="sksk" id="sksk" value="{{$data->sksk}}" required>
                        </div>
                        <div>
                            <label for="nama_lmbg">Lembaga yang Dituju:</label>
                            <input type="text" name="nama_lmbg" id="nama_lmbg" value="{{$data->nama_lmbg}}" required>
                        </div>
                        <div>
                            <label for="jbt_lmbg">Jabatan Pimpinan yang Dituju:</label>
                            <input type="text" name="jbt_lmbg" id="jbt_lmbg" value="{{$data->jbt_lmbg}}" required>
                        </div>
                        <div>
                            <label for="kota_lmbg">Kota / Kabuaten Lembaga:</label>
                            <input type="text" name="kota_lmbg" id="kota_lmbg" value="{{$data->kota_lmbg}}" required>
                        </div>
                        <div>
                            <label for="almt_lmbg">Alamat Lembaga:</label>
                            <input type="text" name="almt_lmbg" id="almt_lmbg" value="{{$data->almt_lmbg}}" required>
                        </div>
                    <div class="mb-3">
                        <label for="catatan_surat" class="form-label">Alasan ditolak</label>
                        <textarea class="form-control" id="catatan_surat" name="catatan_surat" rows="3" disabled>{{ $data->catatan_surat }}</textarea>
                    </div>
                    <button type="submit">Update</button>
                    <a href="/srt_magang">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
