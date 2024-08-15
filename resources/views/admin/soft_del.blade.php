@extends('template/admin')
@section('inti_data')

    <head>
        <title>Manage Akun Mahasiswa</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Halaman Soft Delete</h1>
            <form action="{{ route('admin.soft_delete_search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari.." class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Cari</button>
            </form>
            <a href="/admin/soft_delete" class="btn btn-primary">Reload</a>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Departemen</th>
                        <th class="col-md-1">Program Studi</th>
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
                            <td>{{ $item->nama_dpt }}</td>
                            <td>{{ $item->jenjang_prodi }}</td>
                            <td>
                                <form action="{{ route('admin.restore', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan akun ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                </form>
                                <form onsubmit="return confirm('Yakin ingin menghapus permanen akun ini?')" class="d-inline"
                                    action="{{ route('admin.hard_delete', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="/admin/user" class="btn btn-primary">Kembali</a>
            {{-- {{ $data->withQueryString()->links() }} --}}
        </div>
    </body>
@endsection
