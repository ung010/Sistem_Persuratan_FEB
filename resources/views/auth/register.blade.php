@extends('template/auth')
@section('inti_data')
    <title>Register Akun</title>

    <body class="panduan">
        <div class="container py-5 login">
            <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                <h1>Register</h1>
                <form id="register-form" action="{{ route('register.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ Session::get('email') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" value="{{ Session::get('password') }}"
                                class="form-control">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" value="{{ Session::get('nama') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="nmr_unik" class="form-label">NIM</label>
                        <input type="number" name="nmr_unik" value="{{ Session::get('nmr_unik') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kota" class="form-label">Tempat Lahir</label>
                        <input type="text" name="kota" value="{{ Session::get('kota') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ Session::get('tanggal_lahir') }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ Session::get('nama_ibu') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="nowa" class="form-label">No Handphone</label>
                        <input type="number" name="nowa" value="{{ Session::get('nowa') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="almt_asl" class="form-label">Alamat Asal (Bila asli dari Semarang, masih wajib
                            isi)</label>
                        <input type="text" name="almt_asl" value="{{ Session::get('almt_asl') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="jnjg_id" class="col-sm-2 col-form-label">Jenjang Pendidikan</label>
                        <div class="col-sm-10">
                            <select class="form-select" name='jnjg_id' value="{{ Session::get('jnjg_id') }}" id="jnjg_id">
                                <option value="" selected>Select Option</option>
                                <option value="1">S1</option>
                                <option value="2">S2</option>
                                <option value="3">S3</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dpt_id" class="col-sm-2 col-form-label">Departemen</label>
                        <div class="col-sm-10">
                            <select class="form-select" name='dpt_id' value="{{ Session::get('dpt_id') }}" id="dpt_id">
                                <option value="" selected>Select Option</option>
                                <option value="1">Manajemen</option>
                                <option value="2">IESP</option>
                                <option value="3">Akuntansi</option>
                                <option value="4">Doktor Ilmu Ekonomi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="prd_id" class="col-sm-2 col-form-label">Prodi</label>
                        <div class="col-sm-10">
                            <select class="form-select" name='prd_id' value="{{ Session::get('prd_id') }}" id="prd_id">
                                <option value="" selected>Select Option</option>
                                <option value="1">Manajemen</option>
                                <option value="2">Digital Bisnis</option>
                                <option value="3">Ekonomi</option>
                                <option value="4">Ekonomi Islam</option>
                                <option value="5">Akuntansi</option>
                                <option value="6">Pendidikan Profesi Akuntan</option>
                                <option value="7">Doktor Ilmu Ekonomi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" value="#" id="foto" class="form-control">
                    </div>
                    <h5>Pilih salah satu</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="mahasiswa" id="mahasiswa" required>
                        <label class="form-check-label" for="mahasiswa">
                            Mahasiswa Aktif
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="alumni" id="alumni" required>
                        <label class="form-check-label" for="alumni">
                            Alumni
                        </label>
                    </div>
                    <div class="mb-3 d-grid">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="mb-3 d-grid">
                        <a href='/' class="btn btn-warning">Login</a>
                    </div>
                </form>
                <script>
                    document.getElementById('register-form').addEventListener('submit', function(event) {
                        var password = document.getElementById('password').value;
                        var confirmPassword = document.getElementById('confirm-password').value;

                        if (password !== confirmPassword) {
                            alert('Konfirmasi password tidak cocok!');
                            event.preventDefault(); // Mencegah pengiriman form jika password tidak cocok
                        }
                    });
                </script>

                <script>
                    document.getElementById('togglePassword').addEventListener('click', function(e) {
                        const passwordField = document.getElementById('password');
                        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordField.setAttribute('type', type);
                        this.textContent = type === 'password' ? 'Show' : 'Hide';
                    });
                </script>
            </div>
        </div>
    </body>
@endsection
