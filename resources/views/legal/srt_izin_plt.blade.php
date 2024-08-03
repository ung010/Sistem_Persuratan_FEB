@extends('template/legal')
@section('inti_data')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        @if ($srt_izin_plt->role_surat == 'mahasiswa')
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No Surat</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Nama Lembaga</th>
                        <th class="col-md-1">Judul Data</th>
                        <th class="col-md-1">Tanggal Surat</th>
                        <th class="col-md-1">File Surat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $srt_izin_plt->no_surat }}</td>
                        <td>{{ $srt_izin_plt->nama_mhw }}</td>
                        <td>{{ $srt_izin_plt->nmr_unik }}</td>
                        <td>{{ $srt_izin_plt->nama_lmbg }}</td>
                        <td>{{ $srt_izin_plt->judul_data }}</td>
                        <td>{{ $srt_izin_plt->tanggal_surat }}</td>
                        <td>
                            <a href='{{ url('/legal/srt_izin_plt/view/' . $srt_izin_plt->id) }}'
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
