@extends('legal.layout')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center gap-3"
        style="margin-top: 2%; margin-left: 5%; margin-right: 5%;">
        <img src="{{ asset('asset/Mask group.png') }}" alt="header" class="w-100">
        <br>

        <div class="container-fluid">
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
                                <td>{{ $srt_mhw_asn->nmr_unik }}</td>
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
    </div>
@endsection
