@extends('template/mahasiswa')
@section('inti_data')
<head>
    <title>My Account {{ auth()->user()->nama }}</title>
</head>
<body>
    <div class="container py-5">
        <div class="w-50 center border rounded px-3 py-3 mx-auto">
            <h1>Edit Account</h1>
            <form action='{{ route('mahasiswa.update', $user->id) }}' method='post' enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ $user->nama }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nmr_unik" class="form-label">NIM</label>
                    <input type="text" name="nmr_unik" value="{{ $user->nmr_unik }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="kota" class="form-label">Tempat Lahir</label>
                    <input type="text" name="kota" value="{{ $user->kota }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nowa" class="form-label">No Handphone</label>
                    <input type="text" name="nowa" value="{{ $user->nowa }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ $user->nama_ibu }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="almt_asl" class="form-label">Alamat Asal Rumah</label>
                    <input type="text" name="almt_asl" value="{{ $user->almt_asl }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="jnjg_id" class="col-sm-2 col-form-label">Jenjang Pendidikan</label>
                    <div class="col-sm-10">
                        <select class="form-select" name='jnjg_id' id="jnjg_id">
                            <option value="" {{ $user->jnjg_id == 0 ? 'selected' : '' }}>Select Option</option>
                            <option value="1" {{ $user->jnjg_id == 1 ? 'selected' : '' }}>S1</option>
                            <option value="2" {{ $user->jnjg_id == 2 ? 'selected' : '' }}>S2</option>
                            <option value="3" {{ $user->jnjg_id == 3 ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="dpt_id" class="col-sm-2 col-form-label">Departemen</label>
                    <div class="col-sm-10">
                        <select class="form-select" name='dpt_id' id="dpt_id">
                            <option value="" {{ $user->dpt_id == 0 ? 'selected' : '' }}>Select Option</option>
                            <option value="1" {{ $user->dpt_id == 1 ? 'selected' : '' }}>Manajemen</option>
                            <option value="2" {{ $user->dpt_id == 2 ? 'selected' : '' }}>IESP</option>
                            <option value="3" {{ $user->dpt_id == 3 ? 'selected' : '' }}>Akuntansi</option>
                            <option value="4" {{ $user->dpt_id == 4 ? 'selected' : '' }}>Doktor Ilmu Ekonomi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="prd_id" class="col-sm-2 col-form-label">Prodi</label>
                    <div class="col-sm-10">
                        <select class="form-select" name='prd_id' id="prd_id">
                            <option value="" {{ $user->prd_id == 0 ? 'selected' : '' }}>Select Option</option>
                            <option value="1" {{ $user->prd_id == 1 ? 'selected' : '' }}>Manajemen</option>
                            <option value="2" {{ $user->prd_id == 2 ? 'selected' : '' }}>Digital Bisnis</option>
                            <option value="3" {{ $user->prd_id == 3 ? 'selected' : '' }}>Ekonomi</option>
                            <option value="4" {{ $user->prd_id == 4 ? 'selected' : '' }}>Ekonomi Islam</option>
                            <option value="5" {{ $user->prd_id == 5 ? 'selected' : '' }}>Akuntansi</option>
                            <option value="6" {{ $user->prd_id == 6 ? 'selected' : '' }}>Pendidikan Profesi Akuntan</option>
                            <option value="7" {{ $user->prd_id == 7 ? 'selected' : '' }}>Doktor Ilmu Ekonomi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if($user->foto)
                    <img src="{{ asset('storage/foto/mahasiswa/' . $user->foto) }}" alt="Foto User" class="img-thumbnail" width="150">
                    @endif
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="catatan_user" class="form-label">Catatan dari admin</label>
                    <textarea class="form-control" id="catatan_user" name="catatan_user" rows="3" disabled>{{ $user->catatan_user }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href='/mahasiswa' class="btn btn-info">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
