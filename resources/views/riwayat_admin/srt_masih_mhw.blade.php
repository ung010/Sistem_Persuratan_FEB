@extends('template/admin')
@section('inti_data')
    <a class="btn btn-primary" href="/riwayat_srt/admin/srt_mhw_asn">Surat Masih Mahasiswa Bagi ASN</a>
    <a class="btn btn-primary" href="/riwayat_srt/admin/srt_masih_mhw">Surat Masih Kuliah</a>
    <a class="btn btn-primary" href="/riwayat_srt/admin/srt_magang">Surat Magang</a>
    <a class="btn btn-primary" href="/riwayat_srt/admin/srt_izin_plt">Surat Izin Penelitian</a>
    <a class="btn btn-primary" href="/riwayat_srt/admin/srt_bbs_pnjm">Surat Bebas Pinjam</a>
    <a class="btn btn-primary" href="/riwayat_srt/admin/srt_pmhn_kmbali_biaya">Surat Permohonan
        Pengembalian Biaya Pendidikan</a>
    <a class="btn btn-primary" href="/riwayat_srt/admin/legalisir">Legalisir</a>
    
    <form method="GET" action="{{ route('riwayat_admin.srt_masih_mhw_search') }}">
        <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
        <button type="submit">Cari</button>
    </form>
    <a href="/riwayat_srt/admin/srt_masih_mhw">Reload</a>
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
