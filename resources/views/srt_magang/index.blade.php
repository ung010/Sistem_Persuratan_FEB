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
                        <th>Instansi Tujuan</th>
                        <th>Alamat Instansi</th>
                        <th>Nama / NIM</th>
                        <th>Semester</th>
                        <th>Alamat / No HP</th>
                        <th class="text-center">Lacak</th>
                        <th>Status</th>
                        <th>Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama_lmbg }}</td>
                            <td>{{ $item->almt_lmbg }}</td>
                            <td>
                                {{ $item->nama }} / {{ $item->nmr_unik }}
                            </td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->almt_smg }} / {{ $item->nowa }}</td>
                            @include('user.lacak')
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ url('/srt_magang/edit/' . $item->id) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <a href="{{ url('/srt_magang/download/' . $item->id) }}" class="btn btn-primary btn-sm">Unduh</a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
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
                <form action="{{ route('srt_magang.store') }}" method="POST" class="row px-5">
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
                                <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Program Studi</label>
                                <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">No Whatsapp</label>
                                <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Di Semarang</label>
                                <input type="text" id="almt_smg" name="almt_smg" id="almt_smg" class="form-control">
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-4">Semester</label>
                                <div class="col-8">
                                    <select name="semester" id="semester" required class="form-select">
                                @for ($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-1">SKSK</label>
                                <div class="col-5">
                                    <input type="string" name="ipk" id="ipk" required class="form-control">
                                </div>
                                <label for="" class="col-1">IPK</label>
                                <div class="col-5">
                                    <input type="number" name="sksk" id="sksk" required class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">Lembaga Yang Dituju</label>
                                <input type="text" name="nama_lmbg" id="nama_lmbg" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Jabatan Pemimpin yang Dituju</label>
                                <input type="text" name="jbt_lmbg" id="jbt_lmbg" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Kota / Kabupaten Lembaga</label>
                                <input type="text" name="kota_lmbg" id="kota_lmbg" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Lembaga</label>
                                <input type="text" name="almt_lmbg" id="almt_lmbg" required class="form-control">
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
