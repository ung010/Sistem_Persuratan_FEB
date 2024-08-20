@extends('user.surat') 
@section('content')
<div style="padding: 0 1rem 0 1rem">
    <table style="text-align: justify;">
        <tr>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">Nomor</p>
            </td>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">:</p>
            </td>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">{{ $srt_izin_plt->no_surat }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">Lampiran</p>
            </td>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">:</p>
            </td>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">-</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">Hal</p>
            </td>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">:</p>
            </td>
            <td>
                <p style="font-size: 12px; font-family: 'Times New Roman', Times, serif">Ijin Penelitian</p>
            </td>
        </tr>
    </table>
</div>
<br>
<p style="font-size: 12px; margin-bottom: 1rem; text-align: justify; padding: 0 1rem 0 1rem">
    Yth {{ $srt_izin_plt->jbt_lmbg }}
</p>
<br />
<div style="padding: 0 1rem 0 1rem">
    <p style="font-size: 12px; margin-bottom: 1rem; text-align: justify">
        Dalam rangka mempersiapkan mahasiswa untuk menempuh ujian, maka setiap mahasiswa diwajibkan menyusun paper / skripsi sehingga diperlukan data dari Instansi Pemerintah, Badan Usaha Milik Pemerintah, ataupun Instansi Swasta.
    </p>
    <p style="font-size: 12px; margin: 0; text-align: justify">
        Sehubungan dengan hal tersebut di atas, mohon dapat diijinkan melaksanakan penelitian pada perusahaan/instansi yang Saudara pimpin, bagi mahasiswa Fakultas Ekonomika dan Bisnis tersebut di bawah ini:
    </p>
    <br />
    <table style="margin-left: 5%; text-align: justify; font-size: 12px; font-family: 'Times New Roman', Times, serif;">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->nama_mhw }}</td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->nmr_unik }}</td>
        </tr>
        <tr>
            <td>Departemen / Program Studi</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->nama_dpt }} / {{ $srt_izin_plt->nama_prd }}</td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->almt_asl }}</td>
        </tr>
        <tr>
            <td>No. Telp. / HP</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->nowa }}</td>
        </tr>
        <tr>
            <td>Judul Paper / Skripsi</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->judul_data }}</td>
        </tr>
        <tr>
            <td>Alamat Email</td>
            <td>:</td>
            <td>{{ $srt_izin_plt->email }}</td>
        </tr>
    </table>
    <br />
    <p style="font-size: 12px; margin: 0; text-align: justify">
        Demikian atas segala bantuan serta kerja sama yang baik, kami ucapkan terima kasih.
    </p>
    <br />
    <div style="display: grid; grid-template-columns: auto 1fr; align-items: center; text-align: center;">
        <table style="text-align: justify; font-size: 12px; font-family: 'Times New Roman', Times, serif;">
            <tr>
                <td style="padding-bottom: 1rem">
                    Semarang, {{ $srt_izin_plt->tanggal_surat }}
                </td>
            </tr>
            <tr>
                <td>a.n Dekan,</td>
            </tr>
            <tr>
                <td style="padding-bottom: 1rem">Wakil Dekan Akademik dan Kemahasiswaan,</td>
            </tr>
        </table>
        <div style="text-align: center;">
            <img src="{{ public_path($qrCodePath) }}" alt="QR Code" style="display: block; margin: 0 auto;" />
        </div>
    </div>
    <div style="text-align: right; padding-right: 1rem;">
        <table style="text-align: justify; font-size: 12px; font-family: 'Times New Roman', Times, serif;">
            <tr>
                <td>Prof. Firmansyah, SE., M.Si., Ph.D.</td>
            </tr>
            <tr>
                <td>NIP. 197404271999031001</td>
            </tr>
        </table>
    </div>
</div>
@endsection
