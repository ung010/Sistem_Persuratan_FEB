@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Manage Surat</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Surat Keterangan Mahasiswa</h1>
            <a href="/admin" class="btn btn-primary">Kembali</a>
            <a href="/SuratKetMahasiswa/Create" class="btn btn-primary">Buat Surat</a>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Pengecekan Berkas</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <a href="#" class="btn btn-warning">Cek Berkas</a>
                            </td>
                            <td>
                                <a href='{{ url('/buku/update_admin/edit/' . $item->kode_gabungan_final) }}'
                                    class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody> --}}
            </table>
            {{-- {{ $data->withQueryString()->links() }} --}}
        </div>
    </body>
@endsection
