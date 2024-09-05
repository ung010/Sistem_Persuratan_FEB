@extends('user.layout')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center gap-3"
        style="margin-top: 2%; margin-left: 5%; margin-right: 5%;">
        <img src="{{ asset('asset/Mask group.png') }}" alt="header" class="w-100">
        <button class="btn btn-primary" onclick="addData()">Buat Surat</button>

        <div class="container-fluid">
            <table class="table table-responsive" id="asn">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Departemen</th>
                        <th>Program Studi</th>
                        <th>Alamat Tujuan</th>
                        <th class="text-center">Lacak</th>
                        <th>Status</th>
                        <th>No Resi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td> {{ $item->nama }}</td>
                            <td>{{ $item->nmr_unik }}</td>
                            <td>
                                {{ $item->nama_dpt }}
                            </td>
                            <td>{{ $item->nama_prd }}</td>
                            <td>{{ $item->almt_kirim }}</td>
                            @include('user.lacak')
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm" disabled>Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ route('legalisir.edit', ['id' => Hashids::encode($item->id)]) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa' && $item->ambil == 'ditempat')
                                    Diambil ditempat
                                @else
                                    {{ $item->no_resi }}
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card w-100 d-none" id="card-tambah">
            <div class="card-body d-flex flex-column gap-3">
                <div class="d-flex justify-content-center align-items-center">
                    <h3>ISI DATA</h3>
                </div>
                <form action="{{ route('legalisir.store') }}" method="POST" class="row px-5"
                    enctype="multipart/form-data">
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
                                <label for="">Jenis Legalisir</label>
                                <select name="jenis_lgl" id="jenis_lgl" required class="form-select">
                                    <option value="">Select Option</option>
                                    <option value="ijazah">Ijazah</option>
                                    <option value="transkrip">Transkrip</option>
                                    <option value="ijazah_transkrip">Ijazah dan Transkrip</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Mahasiswa</label>
                                <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <input type="text" id="nama_dpt" name="nama_dpt"
                                    value="{{ $departemen->nama_dpt }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Asal</label>
                                <input type="text" id="almt_asl" name="almt_asl" value="{{ $user->almt_asl }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Tujuan Pengiriman</label>
                                <input type="text" name="almt_smg" id="almt_smg" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Kecamatan</label>
                                <input type="text" name="kcmt_kirim" id="kcmt_kirim" class="form-control">
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-2">Kodepos</label>
                                <div class="col-10">
                                    <input type="number" name="kdps_kirim" id="kdps_kirim" class="form-control">
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-4">Ijazah</label>
                                <div class="col-8">
                                    <input type="file" name="file_ijazah" id="file_ijazah" class="form-control">
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-4">Transkrip</label>
                                <div class="col-8">
                                    <input type="file" name="file_transkrip" id="file_transkrip"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">Keperluan</label>
                                <input type="text" name="keperluan" id="keperluan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Program Studi</label>
                                <input type="text" id="jenjang_prodi" name="jenjang_prodi"
                                    value="{{ $prodi->nama_prd }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">No Whatsapp</label>
                                <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-2">Tanggal Lulus</label>
                                <div class="col-10">
                                    <input type="date" name="tgl_lulus" id="tgl_lulus" class="form-control">
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-2">Pengambilan</label>
                                <div class="col-10">
                                    <select name="ambil" id="ambil" required class="form-select">
                                        <option value="">Select Option</option>
                                        <option value="ditempat">Diambil di Tempat</option>
                                        <option value="dikirim">Dikirim</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Kelurahan</label>
                                <input type="text" name="klh_kirim" id="klh_kirim" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Kota / Kabupaten</label>
                                <input type="text" name="kota_kirim" id="kota_kirim" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger">Kembali</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button class="btn btn-secondary" onclick="resetData()" type="button">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('user.form-script')
@endsection
