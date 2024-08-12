@extends('user.surat') @section('content')
    <table style="width: 100%; text-align: center">
        <tr>
            <td>
                <strong
                    style="
          font-size: 16px;
          font-family: 'Times New Roman', Times, serif;
          text-align: justify;
        "><u>KETERANGAN
                        BEBAS PINJAM</u></strong>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 12px; margin: 0">
                    Nomor: {{ $srt_bbs_pnjm->no_surat }}
                </p>
            </td>
        </tr>
    </table>
    <br />
    <div style="padding: 0 1rem 0 1rem">
        <p style="font-size: 12px; margin: 0; text-align: justify">
            Yang bertanda tangan di bawah ini, Supervisor Sumberdaya Fakultas Ekonomika dan Bisnis Universitas Diponegoro,
            menerangkan bahwa mahasiswa :
        </p>
        <br />
        <table
            style="
      margin-left: 5%;
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    ">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $srt_bbs_pnjm->nama_mhw }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $srt_bbs_pnjm->nmr_unik }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $srt_bbs_pnjm->jenjang_prodi }}</td>
            </tr>
            <tr>
                <td>Dosen Wali</td>
                <td>:</td>
                <td>{{ $srt_bbs_pnjm->dosen_wali }}</td>
            </tr>
            <tr>
                <td>Alamat Semarang</td>
                <td>:</td>
                <td>{{ $srt_bbs_pnjm->almt_smg }}</td>
            </tr>
            <tr>
                <td>No Whatsapp</td>
                <td>:</td>
                <td>{{ $srt_bbs_pnjm->nowa }}</td>
            </tr>
        </table>
        <br />
        <p style="font-size: 12px; margin: 0; text-align: justify">
            Dinyatakan telah "Bebas Pinjam" (tidak meminjam asset yang dimiliki oleh Fakultas Ekonomika dan Bisnis
            Universitas Diponegoro)
        </p>
        <br />
        <table
            style="
            margin-right: 5%;
            text-align: justify;
            font-size: 12px;
            font-family: 'Times New Roman', Times, serif;
          "
            align="right">
            <tr>
                <td>
                    Semarang, {{ $srt_bbs_pnjm->tanggal_surat }}
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 1rem;">Supervisor Sumberdaya</td>
            </tr>
            <tr>
                <td style="padding-bottom: 1rem; text-align: center;">
                    <img src="{{ public_path($qrCodePath) }}" alt="QR Code" />
                </td>
            </tr>
            <tr>
                <td>Suryani, S.E</td>
            </tr>
            <tr>
                <td>NIP. H.7.198601242009082001</td>
            </tr>
        </table>
    </div>
@endsection
