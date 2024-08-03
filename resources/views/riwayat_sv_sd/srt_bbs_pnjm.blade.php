@extends('template/supervisor_sd')
@section('inti_data')
    <a class="btn btn-primary" href="/riwayat_srt/sv_sd/srt_bbs_pnjm">Surat Bebas Pinjam</a>
    <a class="btn btn-primary" href="/riwayat_srt/sv_sd/srt_pmhn_kmbali_biaya">Surat Permohonan
        Pengembalian Biaya Pendidikan</a>
    
    <form method="GET" action="{{ route('riwayat_sv_sd.srt_bbs_pnjm_search') }}">
        <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
        <button type="submit">Cari</button>
    </form>
    <a href="/riwayat_srt/sv_sd/srt_bbs_pnjm">Reload</a>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-1">Nama Mahasiswa</th>
                    <th class="col-md-1">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama_mhw }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm">Selesai</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $data->withQueryString()->links() }}
@endsection
