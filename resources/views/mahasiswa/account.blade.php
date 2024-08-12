@extends('user.layout')

@section('content')
    <div class="d-flex justify-content-center align-items-center gap-4" style="margin-top: 1%;">
        <div class="card">
            <div class="card-body p-5 row">
                <div class="d-flex justify-content-center align-items-center">
                    <h3>DATA DIRI</h3>
                </div>
                <form action='{{ route('mahasiswa.update', $user->id) }}' method='post' enctype="multipart/form-data" class="row">
                    @csrf
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" id=""
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama" value="{{ $user->nama }}" id=""
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="number" name="nmr_unik" value="{{ $user->nmr_unik }}" id=""
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Ibu</label>
                                <input type="text" name="nama_ibu" value="{{ $user->nama_ibu }}" id=""
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">No Handphone</label>
                                <input type="text" name="nowa" value="{{ $user->nowa }}" id=""
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Asal</label>
                                <input type="text" name="almt_asl" value="{{ $user->almt_asl }}" id=""
                                class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="">Tempat Lahir</label>
                                <input type="text" name="kota" value="{{ $user->kota }}" id=""
                                    class="form-control">
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="col-4">Tanggal Lahir</label>
                                <div class="col-4">
                                    <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}"
                                        id="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">Jenjang Pendidikan</label>
                                    <select class="form-select" name='jnjg_id' id="jnjg_id">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($jenjang_pendidikan as $jjg)
                                            <option value="{{ $jjg->id }}"
                                                {{ $jjg->id == $user->jnjg_id ? 'selected' : '' }}>
                                                {{ $jjg->nama_jnjg }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="">Departemen</label>
                                    <select class="form-select" name='dpt_id' id="dpt_id">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($departemen as $dpt)
                                            <option value="{{ $dpt->id }}"
                                                {{ $dpt->id == $user->dpt_id ? 'selected' : '' }}>
                                                {{ $dpt->nama_dpt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">Program Studi</label>
                                    <select class="form-select" name='prd_id' id="prd_id">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($prodi as $prd)
                                            <option value="{{ $prd->id }}"
                                                {{ $prd->id == $user->prd_id ? 'selected' : '' }}>
                                                {{ $prd->nama_prd }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 d-flex flex-column gap-1">
                                    <div class="d-flex gap-2">
                                        <input type="radio" name="status" id="" value="mahasiswa"
                                            {{ $user->status == 'mahasiswa' ? 'checked' : '' }}> Mahasiswa Aktif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <input type="radio" name="status" id="" value="alumni"
                                            {{ $user->status == 'alumni' ? 'checked' : '' }}> Alumni
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="">Identitas</label>
                                <img src="{{ asset('storage/foto/mahasiswa/' . $user->foto) }}" alt="identitas" style="max-width: 280px">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
