@extends('template/manajer')
@section('inti_data')

    <head>
        <title>
            Manajer - Surat Keterangan Masih Mahasiswa
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_masih_mhw.manajer_search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_masih_mhw/manajer">Reload</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Keperluan</th>
                        <th class="col-md-1">Cek Data</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama_mhw }}</td>
                            <td>{{ $item->tujuan_buat_srt }}</td>
                            <td>
                                @if($item->tujuan_akhir == 'manajer')
                                    <form action="{{ route('srt_masih_mhw.setuju_manajer', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Disetujui</button>
                                    </form>
                                @elseif($item->tujuan_akhir == 'wd')
                                    <form action="{{ route('srt_masih_mhw.setuju_wd', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Disetujui</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->withQueryString()->links() }}
    @endsection
