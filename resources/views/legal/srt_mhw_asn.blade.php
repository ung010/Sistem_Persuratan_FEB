@extends('template/legal')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        @if ($srt_mhw_asn)
            @if ($srt_mhw_asn->role_surat == 'mahasiswa')
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="col-md-1">No Surat</th>
                            <th class="col-md-1">Nama Mahasiswa</th>
                            <th class="col-md-1">NIM</th>
                            <th class="col-md-1">Periode</th>
                            <th class="col-md-1">Tanggal Surat</th>
                            <th class="col-md-1">File Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $srt_mhw_asn->no_surat }}</td>
                            <td>{{ $srt_mhw_asn->nama_mhw }}</td>
                            <td>{{ $srt_mhw_asn->nim_mhw }}</td>
                            <td>{{ $srt_mhw_asn->thn_awl }} / {{ $srt_mhw_asn->thn_akh }}</td>
                            <td>{{ $srt_mhw_asn->tanggal_surat }}</td>
                            <td>
                                <a href='{{ url('/legal/srt_mhw_asn/view/' . $srt_mhw_asn->id) }}'
                                    class="btn btn-primary btn-sm">Lihat Surat</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <h3>Surat belum legal</h3>
            @endif
        @else
            <h3>Surat kosong</h3>
        @endif
    </div>
@endsection
