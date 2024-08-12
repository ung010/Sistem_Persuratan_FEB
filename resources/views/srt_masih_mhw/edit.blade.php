@extends('user.layout')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center gap-3"
        style="margin-top: 2%; margin-left: 5%; margin-right: 5%;">
        <img src="{{ asset('asset/Mask group.png') }}" alt="header" class="w-100">
    </div>

    <div class="d-flex mt-5 mb-3" style="margin-left: 5%; margin-right: 5%;">
        <div class="card">
            <div class="card-body p-3">
                <h3>Alasan Surat Di Tolak: {{ $data->catatan_surat }}</h3>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center gap-3"
        style="margin-left: 5%; margin-right: 5%;">
        <div class="card w-100" id="card-tambah">
            <div class="card-body d-flex flex-column gap-3">
                <div class="d-flex justify-content-center align-items-center">
                    <h3>ISI DATA</h3>
                </div>
                <form action="{{ route('srt_masih_mhw.update', $data->id) }}" method="POST" class="row px-5">
                    @csrf
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">Nama Mahasiswa</label>
                                <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <input type="text" id="nama_dpt" name="nama_dpt"
                                    value="{{ $departemen->nama_dpt }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Jenjang Studi</label>
                                <input type="text" id="nama_jnjg" name="nama_jnjg" value="{{ $jenjang->nama_jnjg }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-4">Tahun Ajaran</label>
                                <div class="col-8 d-flex">
                                    <input type="number" name="thn_awl" id="thn_awl" class="form-control" value="{{ $data->thn_awl }}">
                                    <p>/</p>
                                    <input type="number" name="thn_akh" id="thn_akh" class="form-control" value="{{ $data->thn_akh }}">
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-4">Semester</label>
                                <div class="col-8">
                                    <select name="semester" id="semester" required class="form-select">
                                        @for ($i = 1; $i <= 14; $i++)
                                            <option value="{{ $i }}" {{ $data->semester == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input type="text" id="almt_smg" name="almt_smg" id="almt_smg"
                                    class="form-control" value="{{ $data->almt_smg }}">
                            </div>
                            <div class="form-group">
                                <label for="">Tempat, Tanggal Lahir</label>
                                <input type="text" id="kota_tanggal_lahir" name="kota_tanggal_lahir"
                                    value="{{ $kota_tanggal_lahir }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Tujuan Pembuatan Surat</label>
                                <input type="text" name="tujuan_buat_srt" id="tujuan_buat_srt" class="form-control" value="{{ $data->tujuan_buat_srt }}">
                            </div>
                            <div class="form-group">
                                <label for="">No Whatsapp</label>
                                <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row py-5">
                      <div class="col d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-success">Perbarui</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
