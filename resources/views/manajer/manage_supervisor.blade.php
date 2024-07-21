@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Manage Supervisor</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Manage Supervisor</h1>
            {{-- <form action="{{ route('admin.user.search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari.." class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Cari</button>
            </form>
            <a href="/admin/user" class="btn btn-primary">Reload</a> --}}
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
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#manager_edit_spv_modal_{{ $item->id }}">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="/manajer" class="btn btn-primary">Kembali</a>
            {{ $data->withQueryString()->links() }}
        </div>
        @foreach ($data as $item)
            <div class="modal fade" id="manager_edit_spv_modal_{{ $item->id }}" tabindex="-1"
                aria-labelledby="edit_sd_modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('manajer.edit_spv', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="manager_edit_spv_modalLabel">Edit Admin</h5>
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
