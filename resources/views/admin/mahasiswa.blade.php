@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Manage Akun Mahasiswa</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Akun Mahasiswa</h1>
            <a href="/admin" class="btn btn-primary">Kembali</a>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
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
                                <a href="#" class="btn btn-warning">Edit</a>
                                <form onsubmit="return confirm('Yakin ingin menghapus akun ini?')" class="d-inline" action="{{ route('mahasiswa.delete', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                            {{-- <td>
                            <a href='{{ url('/buku/update_admin/edit/'.$item->kode_gabungan_final) }}' class="btn btn-warning btn-sm">Edit</a>
                            
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->withQueryString()->links() }}
        </div>
    </body>
@endsection
