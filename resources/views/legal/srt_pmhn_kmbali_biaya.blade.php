@extends('template/legal')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        @if ($srt_pmhn_kmbali_biaya->role_surat == 'mahasiswa')
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No Surat</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Program Studi</th>
                        <th class="col-md-1">Tanggal Surat</th>
                        <th class="col-md-1">File Surat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $srt_pmhn_kmbali_biaya->no_surat }}</td>
                        <td>{{ $srt_pmhn_kmbali_biaya->nama_mhw }}</td>
                        <td>{{ $srt_pmhn_kmbali_biaya->nmr_unik }}</td>
                        <td>{{ $srt_pmhn_kmbali_biaya->jenjang_prodi }}</td>
                        <td>{{ $srt_pmhn_kmbali_biaya->tanggal_surat }}</td>
                        <td>
                            <a href='{{ url('/legal/srt_pmhn_kmbali_biaya/view/' . $srt_pmhn_kmbali_biaya->id) }}'
                                class="btn btn-primary btn-sm">Lihat Surat</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <h3>Surat belum legal</h3>
        @endif
    </div>
@endsection
