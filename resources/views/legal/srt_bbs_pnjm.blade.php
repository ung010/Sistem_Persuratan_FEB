@extends('legal.layout')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center gap-3"
        style="margin-top: 2%; margin-left: 5%; margin-right: 5%;">
        <img src="{{ asset('asset/Mask group.png') }}" alt="header" class="w-100">
        <br>

        <div class="container-fluid">
            @if ($srt_bbs_pnjm)
                @if ($srt_bbs_pnjm->role_surat == 'mahasiswa')
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="col-md-1">No Surat</th>
                                <th class="col-md-1">Nama Mahasiswa</th>
                                <th class="col-md-1">NIM</th>
                                <th class="col-md-1">Dosen Wali</th>
                                <th class="col-md-1">Program Studi</th>
                                <th class="col-md-1">Tanggal Surat</th>
                                <th class="col-md-1">File Surat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $srt_bbs_pnjm->no_surat }}</td>
                                <td>{{ $srt_bbs_pnjm->nama_mhw }}</td>
                                <td>{{ $srt_bbs_pnjm->nmr_unik }}</td>
                                <td>{{ $srt_bbs_pnjm->dosen_wali }}</td>
                                <td>{{ $srt_bbs_pnjm->nama_prd }}</td>
                                <td>{{ $srt_bbs_pnjm->tanggal_surat }}</td>
                                <td>
                                    <a href='{{ url('/legal/srt_bbs_pnjm/view/' . $srt_bbs_pnjm->id) }}'
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
    </div>
@endsection
