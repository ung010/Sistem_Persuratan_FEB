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
                        <th>Alamat / No Hp</th>
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
                            <td> {{ $item->nama }}</td>
                            <td>{{ $item->nmr_unik }}</td>
                            <td>
                                {{ $item->nama_dpt }}
                            </td>
                            <td>{{ $item->jenjang_prodi }}</td>
                            <td>{{ $item->almt_smg }} / {{ $item->nowa }}</td>
                            @include('user.lacak')
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ url('/srt_bbs_pnjm/edit/' . $item->id) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <a href="{{ url('/srt_bbs_pnjm/download/' . $item->id) }}"
                                        class="btn btn-primary btn-sm">Unduh</a>
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
                <form action="{{ route('srt_bbs_pnjm.store') }}" method="POST" class="row px-5">
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
                                <label for="">Dosen Wali</label>
                                <input type="text" name="dosen_wali" id="dosen_wali" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Di Semarang</label>
                                <input type="text" name="almt_smg" id="almt_smg" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Program Studi</label>
                                <input type="text" id="jenjang_prodi" name="jenjang_prodi"
                                    value="{{ $jenjang_prodi }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">No Whatsapp</label>
                                <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}"
                                    class="form-control" readonly>
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
