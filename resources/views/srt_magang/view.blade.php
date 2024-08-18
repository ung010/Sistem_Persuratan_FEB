@extends('user.surat') @section('content')
    <div style="padding: 0 1rem 0 1rem">
        <table style=" text-align: justify;">
            <tr>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        Nomor
                    </p>
                </td>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        :
                    </p>
                </td>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        {{ $srt_magang->no_surat }}
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        Lampiran
                    </p>
                </td>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        :
                    </p>
                </td>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        Hal
                    </p>
                </td>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        :
                    </p>
                </td>
                <td>
                    <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">
                        Ijin Magang
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <p style="font-size: 12px; margin-bottom: 1rem; text-align: justify; padding: 0 1rem 0 1rem">
        Yth {{ $srt_magang->jbt_lmbg }}
    </p>
    <br />
    <div style="padding: 0 1rem 0 1rem">
        <p style="font-size: 12px; margin-bottom: 1rem; text-align: justify">
            Dalam rangka mempersiapkan mahasiswa Fakultas Ekonomika dan Bisnis
            Universitas Diponegoro mengenal praktik bisnis/organisasi dan
            membandingkannya dengan teori yang diperoleh selama kuliah, maka kami
            mendorong mahasiswa untuk melakukan kegiatan magang pada perusahaan atau
            instansi pemerintah.
        </p>
        <p style="font-size: 12px; margin: 0; text-align: justify">
            Sehubungan dengan hal tersebut di atas, kami mohon dapat diijinkan melaksanakan Magang pada perusahaan/instansi
            yang Saudara pimpin, bagi mahasiswa Fakultas Ekonomika dan Bisnis tersebut di bawah ini :
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
                <td>{{ $srt_magang->nama_mhw }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $srt_magang->nmr_unik }}</td>
            </tr>
            <tr>
                <td>Departemen / Program Studi</td>
                <td>:</td>
                <td>{{ $srt_magang->nama_dpt }} / {{ $srt_magang->nama_prd }}</td>
            </tr>
            <tr>
                <td>Alamat Rumah</td>
                <td>:</td>
                <td>{{ $srt_magang->almt_smg }}</td>
            </tr>
            <tr>
                <td>No. Telp. / HP</td>
                <td>:</td>
                <td>{{ $srt_magang->nowa }}</td>
            </tr>
            <td>Alamat Email</td>
            <td>:</td>
            <td>{{ $srt_magang->email }}</td>
            </tr>
        </table>
        <br />
        <p style="font-size: 12px; margin: 0; text-align: justify">
            Demikian permohonan kami dan atas segala bantuan serta kerja sama yang baik kami ucapkan terima kasih.
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
                <td style="padding-bottom: 1rem">
                    Semarang, {{ $srt_magang->tanggal_surat }}
                </td>
            </tr>
            <tr>
                <td>a.n Dekan,</td>
            </tr>
            <tr>
                <td style="padding-bottom: 1rem">Wakil Dekan Akademik dan Kemahasiswaan,</td>
            </tr>
            <tr>
                <td style="padding-bottom: 1rem; text-align: center">
                    <img src="{{ public_path($qrCodePath) }}" alt="QR Code" />
                </td>
            </tr>
            <tr>
                <td>Prof. Firmansyah, SE., M.Si., Ph.D.</td>
            </tr>
            <tr>
                <td>NIP. 197404271999031001</td>
            </tr>
        </table>
    </div>
@endsection
