@extends('template/legal')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        @if ($srt_masih_mhw->role_surat == 'mahasiswa')
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No Surat</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Program Studi</th>
                        <th class="col-md-1">Alasan Surat</th>
                        <th class="col-md-1">Tanggal Surat</th>
                        <th class="col-md-1">File Surat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $srt_masih_mhw->no_surat }}</td>
                        <td>{{ $srt_masih_mhw->nama_mhw }}</td>
                        <td>{{ $srt_masih_mhw->nmr_unik }}</td>
                        <td>{{ $srt_masih_mhw->jenjang_prodi }}</td>
                        <td>{{ $srt_masih_mhw->tujuan_buat_srt }}</td>
                        <td>{{ $srt_masih_mhw->tanggal_surat }}</td>
                        <td>
                            <a href='{{ url('/legal/srt_masih_mhw/view/' . $srt_masih_mhw->id) }}'
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
