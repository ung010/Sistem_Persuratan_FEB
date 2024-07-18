@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Manage Akun Mahasiswa Belum di approve</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Akun Mahasiswa Belum di approve</h1>
            <a href="/admin/mahasiswa" class="btn btn-primary">Kembali</a>
            <form id="ApproveAllForm" onsubmit="return confirm('Yakin ingin meng-approve semua akun?')" action="{{ url('/admin/mahasiswa/ApproveAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">Approve Semua</button>
            </form>
            <form action="{{ route('admin.akses.search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari mahasiswa..." class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Cari</button>
            </form>
            <a href="/admin/mahasiswa/akses" class="btn btn-primary">Reload</a>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">
                            <input class="form-check-input" type="checkbox" id="checkAll">
                        </th>
                        <th class="col-md-1">Foto</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Email</th>
                        <th class="col-md-1">No Handphone</th>
                        <th class="col-md-1">Tempat Tanggal Lahir</th>
                        <th class="col-md-1">Alamat Asli</th>
                        <th class="col-md-1">Alamat Semarang</th>
                        <th class="col-md-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>
                                <input class="form-check-input checkItem" type="checkbox" value="{{ $item->id }}">
                            </td>
                            <td>
                                @if ($item->foto)
                                    <img style="max-width:50px;max-height:50px"
                                        src="{{ url('storage\foto\mahasiswa') . '/' . $item->foto }}" />
                                @endif
                            </td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->nowa }}</td>
                            <td>{{ $item->ttl }}</td>
                            <td>{{ $item->almt_asl }}</td>
                            <td>{{ $item->almt_smg }}</td>
                            <td>
                                <form action="{{ url('/admin/mahasiswa/Approve/'.$item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                </form>
                                {{-- <form onsubmit="return confirm('Yakin ingin menghapus akun ini?')" class="d-inline" action="{{ route('mahasiswa.delete', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script>
                document.getElementById('checkAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('.checkItem');
                    for (var checkbox of checkboxes) {
                        checkbox.checked = this.checked;
                    }
                });
            </script>

            <!-- Form untuk mengirimkan ID yang dipilih -->
            <form id="bulkApproveForm" action="{{ url('/admin/mahasiswa/bulkApprove') }}" method="POST">
                @csrf
                <input type="hidden" name="selected_ids" id="selected_ids">
                <button type="button" class="btn btn-primary" onclick="submitBulkApprove()">Approve
                    Semua</button>
            </form>

            <!-- Tambahkan JavaScript -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                document.getElementById('checkAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('.checkItem');
                    for (var checkbox of checkboxes) {
                        checkbox.checked = this.checked;
                    }
                });

                function submitBulkApprove() {
                    var selectedIds = [];
                    var checkboxes = document.querySelectorAll('.checkItem:checked');
                    for (var checkbox of checkboxes) {
                        selectedIds.push(checkbox.value);
                    }

                    if (selectedIds.length === 0) {
                        alert('Silakan pilih setidaknya satu akun untuk di approve.');
                        return;
                    }

                    document.getElementById('selected_ids').value = selectedIds.join(',');
                    document.getElementById('bulkApproveForm').submit();
                }
            </script>

            {{ $data->withQueryString()->links() }}
        </div>
    </body>
@endsection
