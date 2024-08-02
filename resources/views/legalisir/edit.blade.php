@extends('template/mahasiswa')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h2>Edit Surat</h2>
                <form method="POST" action="{{ route('legalisir.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="jenis_lgl">Jenis Legalisir:</label>
                        <select name="jenis_lgl" id="jenis_lgl" required>
                            <option value="ijazah" {{ $data->jenis_lgl == 'ijazah' ? 'selected' : '' }}>Ijazah</option>
                            <option value="transkrip" {{ $data->jenis_lgl == 'transkrip' ? 'selected' : '' }}>Transkrip</option>
                            <option value="ijazah_transkrip" {{ $data->jenis_lgl == 'ijazah_transkrip' ? 'selected' : '' }}>Ijazah dan Transkrip</option>
                        </select>
                    </div>
                    <div>
                        <label for="nama_mhw">Nama Mahasiswa:</label>
                        <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                    </div>
                    <div>
                        <label for="nama_dpt">Departemen:</label>
                        <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}"
                            readonly>
                    </div>
                    <div>
                        <label for="almt_asl">Alamat Asal:</label>
                        <input type="text" id="almt_asl" name="almt_asl" value="{{ $user->almt_asl }}" readonly>
                    </div>
                    <div>
                        <label for="almt_kirim">Alamat Tujuan Pengiriman:</label>
                        <input type="text" name="almt_kirim" id="almt_kirim" value="{{$data->almt_kirim}}">
                    </div>
                    <div>
                        <label for="kcmt_kirim">Kecamatan:</label>
                        <input type="text" name="kcmt_kirim" id="kcmt_kirim" value="{{$data->kcmt_kirim}}">
                    </div>
                    <div>
                        <label for="kdps_kirim">Kode Pos:</label>
                        <input type="number" name="kdps_kirim" id="kdps_kirim" value="{{$data->kdps_kirim}}">
                    </div>
                    <div class="mb-3">
                        <label for="file_ijazah" class="form-label">File Ijazah:</label>
                        <input type="file" name="file_ijazah" id="file_ijazah" class="form-control">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="file_transkrip" class="form-label">File Transkrip:</label>
                        <input type="file" name="file_transkrip" id="file_transkrip" class="form-control">
                    </div>
                    <div>
                        <label for="keperluan">Keperluan:</label>
                        <input type="text" name="keperluan" id="keperluan" value="{{$data->keperluan}}" required>
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
                    <div>
                        <label for="tgl_lulus" class="form-label">Tanggal Lulus:</label>
                        <input type="date" name="tgl_lulus" id="tgl_lulus"
                            class="form-control" value="{{ $data->tgl_lulus }}" required>
                    </div>                        
                    <div>
                        <label for="ambil">Pengambilan:</label>
                        <select name="ambil" id="ambil" required>
                            <option value="ditempat" {{ $data->ambil == 'ditempat' ? 'selected' : '' }}>Diambil Ditempat</option>
                            <option value="dikirim" {{ $data->ambil == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        </select>
                    </div>
                    <div>
                        <label for="klh_kirim">Kelurahan:</label>
                        <input type="text" name="klh_kirim" id="klh_kirim" value="{{$data->klh_kirim}}">
                    </div>
                    <div>
                        <label for="kota_kirim">Kota/Kabupaten:</label>
                        <input type="text" name="kota_kirim" id="kota_kirim" value="{{$data->kota_kirim}}">
                    </div>
                    <button type="submit">Update</button>
                    <a href="/legalisir">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
