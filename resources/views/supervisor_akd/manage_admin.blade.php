@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Manage Admin</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Akun Admin</h1>
            {{-- <form action="{{ route('admin.user.search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari.." class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Cari</button>
            </form>
            <a href="/admin/user" class="btn btn-primary">Reload</a> --}}
            <div class="mb-3 d-grid">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#create_akd_modal">Tambah</button>
            </div>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Admin</th>
                        <th class="col-md-1">NIP</th>
                        <th class="col-md-1">Email</th>
                        <th class="col-md-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nmr_unik }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_akd_modal_{{ $item->id }}">Edit</button>
                                <form onsubmit="return confirm('Yakin ingin menghapus data admin ini?')" class="d-inline"
                                    action="{{ route('supervisor_akd.delete', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="/supervisor_akd" class="btn btn-primary">Kembali</a>
            {{ $data->withQueryString()->links() }}
        </div>
        <div class="modal fade" id="create_akd_modal" tabindex="-1" aria-labelledby="create_akd_modalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('supervisor_akd.create_akd') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_akd_modalLabel">Tambah Admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nmr_unik" class="form-label">NIP</label>
                                <input type="number" name="nmr_unik" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($data as $item)
            <div class="modal fade" id="edit_akd_modal_{{ $item->id }}" tabindex="-1"
                aria-labelledby="edit_akd_modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('supervisor_akd.edit_akd', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit_akd_modalLabel">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" value="{{ $item->nama }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="nmr_unik" class="form-label">NIP</label>
                                    <input type="number" name="nmr_unik" value="{{ $item->nmr_unik }}"
                                        class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $item->email }}"
                                        class="form-control">
                                </div>
                                <label for="password" class="form-label">Password (Kosongkan jika tidak ingin
                                    mengubah)</label>
                                <div class="input-group">
                                    <input type="password" id="edit_password_{{ $item->id }}" name="password"
                                        class="form-control">
                                    <button type="button" class="btn btn-outline-secondary togglePassword"
                                        data-id="{{ $item->id }}">Show</button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </body>
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
@endsection
