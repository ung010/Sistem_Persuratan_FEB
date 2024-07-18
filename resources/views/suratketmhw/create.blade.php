@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Pembuatan Surat Ket Mahasiswa</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Surat Keterangan Mahasiswa</h1>
            <a href="/admin" class="btn btn-primary">Kembali</a>
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
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form id="register-form" action="{{ route('SKM.create') }}" method="post" enctype="multipart/form-data">
                @csrf                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mahasiswa</label>
                    <input type="text" name="nama" value="{{ Session::get('nama') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" name="nim" value="{{ Session::get('nim') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama_prd" class="form-label">Program Studi</label>
                    <input type="text" name="nama_prd" value="{{ Session::get('nama_prd') }}" class="form-control">
                </div>                
                <div class="mb-3">
                    <label for="almt_smg" class="form-label">Alamat</label>
                    <input type="text" name="almt_smg" value="{{ Session::get('almt_smg') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nowa" class="form-label">No Handphone (WA Aktif)</label>
                    <input type="number" name="nowa" value="{{ Session::get('nowa') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tjn_srt" class="form-label">Tujuan Pembuatan Surat</label>
                    <input type="text" name="tjn_srt" value="{{ Session::get('tjn_srt') }}" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </body>
@endsection
