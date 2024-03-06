@extends('template/dasar')
@section('inti_data')
<title>Register Akun</title>
<body class="panduan">
    <div class="container py-5 login">
        <div class="w-50 center border rounded px-3 py-3 mx-auto land">
            <h1>Register</h1>
            <form action="{{ route('register.create') }}" method="post" enctype="multipart/form-data">
                @csrf                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ Session::get('email') }}" class="form-control">
                </div>                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" value="{{ Session::get('password') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ Session::get('nama') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" name="nim" value="{{ Session::get('nim') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="ttl" class="form-label">Tempat Tanggal Lahir (Format : Jakarta, 08 Maret 2012)</label>
                    <input type="text" name="ttl" value="{{ Session::get('ttl') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nowa" class="form-label">No Handphone (WA Aktif)</label>
                    <input type="number" name="nowa" value="{{ Session::get('nowa') }}" class="form-control">
                </div>                
                <div class="mb-3">
                    <label for="almt_smg" class="form-label">Alamat di Semarang (Wajib isi)</label>
                    <input type="text" name="almt_smg" value="{{ Session::get('almt_smg') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="almt_asl" class="form-label">Alamat Asal (Bila asli dari Semarang, masih wajib isi)</label>
                    <input type="text" name="almt_asl" value="{{ Session::get('almt_asl') }}" 
                    class="form-control">
                </div>
                <div class="mb-3">
                    <label for="dpt_id" class="col-sm-2 col-form-label">Departemen</label>
                    <div class="col-sm-10">
                        <select class="form-select" name='dpt_id' value="{{ Session::get('dpt_id')}}" id="dpt_id">
                            <option value="1" selected>-</option>
                            <option value="2">Manajemen</option>
                            <option value="3">IESP</option>
                            <option value="4">Akuntansi</option>
                            <option value="5">Doktor Ilmu Ekonomi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="prd_id" class="col-sm-2 col-form-label">Prodi</label>
                    <div class="col-sm-10">
                        <select class="form-select" name='prd_id' value="{{ Session::get('prd_id')}}" id="prd_id">
                            <option value="1" selected>-</option>
                            <option value="2">S1 - Digital Bisnis</option>
                            <option value="3">S1 - Manajemen</option>
                            <option value="4">S2 - Manajemen</option>
                            <option value="5">S1 - Ekonomi</option>
                            <option value="6">S2 - Ekonomi</option>
                            <option value="7">S1 - Ekonomi Islam</option>
                            <option value="8">S1 - Akuntansi</option>
                            <option value="9">S2 - Akuntansi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" value="#" id="foto"
                    class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="mb-3 d-grid">
                    <a href='/' class="btn btn-warning">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection