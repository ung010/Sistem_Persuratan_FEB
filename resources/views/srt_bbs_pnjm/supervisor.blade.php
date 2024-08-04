@extends('template/supervisor_sd')
@section('inti_data')

    <head>
        <title>
            Supervisor - Surat Keterangan Masih Mahasiswa
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_bbs_pnjm.sv_search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_bbs_pnjm/supervisor">Reload</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Cek Data</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama_mhw }}</td>
                            <td>{{ $item->nmr_unik }}</td>
                            <td>
                                <form action="{{ route('srt_bbs_pnjm.sv_setuju', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Disetujui</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->withQueryString()->links() }}
    @endsection