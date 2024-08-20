@extends('user.surat') 
@section('content')
<table style="width: 100%; text-align: center">
  <tr>
    <td>
      <strong
        style="
          font-size: 16px;
          font-family: 'Times New Roman', Times, serif;
          text-align: justify;
        "
        ><u>SURAT PERMOHONAN PENGEMBALIAN BIAYA PENDIDIKAN</u></strong
      >
    </td>
  </tr>
</table>
<br />
<div style="padding: 0 1rem 0 1rem">
  <p style="font-size: 12px; margin: 0; text-align: justify; margin-bottom: 1em">
    Yth. Wakil Rektor Sumber Daya
  </p>
  <p style="font-size: 12px; margin: 0; text-align: justify">
    Universitas Diponegoro
  </p>
  <br>
  <p style="font-size: 12px; margin: 0; text-align: justify">
    Bersama ini saya mahasiswa Fakultas Ekonomika dan Bisnis Universitas Diponegoro dengan identitas sebagai berikut:
  </p>
  <br />
  <table
    style="
      margin-left: 5%;
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    "
  >
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>{{ $srt_pmhn_kmbali_biaya->nama_mhw }}</td>
    </tr>
    <tr>
      <td>NIM</td>
      <td>:</td>
      <td>{{ $srt_pmhn_kmbali_biaya->nmr_unik }}</td>
    </tr>
    <tr>
      <td>Program Studi</td>
      <td>:</td>
      <td>{{ $srt_pmhn_kmbali_biaya->nama_prd }}</td>
    </tr>
    <tr>
      <td>Tempat / Tanggal Lahir</td>
      <td>:</td>
      <td>{{ $srt_pmhn_kmbali_biaya->ttl }}</td>
    </tr>
    <tr>
      <td>Alamat Rumah</td>
      <td>:</td>
      <td>{{ $srt_pmhn_kmbali_biaya->almt_asl }}</td>
    </tr>
    <tr>
      <td>No. Telp./HP</td>
      <td>:</td>
      <td>{{ $srt_pmhn_kmbali_biaya->nowa }}</td>
    </tr>
  </table>
  <br />
  <p style="font-size: 12px; margin: 0; text-align: justify">
    Mengajukan permohonan pengembalian UKT berkenaan dengan Surat Rektor Nomor: {{ $srt_pmhn_kmbali_biaya->no_surat }}
  </p>
  <br />
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    "
  >
    Berikut saya lampirkan data dukung sebagaimana persyaratan dalam surat tersebut:
  </p>
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
      margin-left: 1rem;
    "
  >
    a. SKL yang ditandatangani oleh pimpinan fakultas;
  </p>
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
      margin-left: 1rem;
    "
  >
    b. Foto Copy Bukti Bayar;
  </p>
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
      margin-left: 1rem;
    "
  >
    c. Foto Copy Buku Tabungan atas nama mahasiswa yang bersangkutan
  </p>
  <br />
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    "
  >
    Demikian permohonan saya, atas perhatian Bapak saya ucapkan terima kasih.
  </p>
  <br />
  <div style="display: grid; grid-template-rows: auto auto 1fr; height: 200px; width: 100%;">
    <div style="grid-row: 1; padding-right: 100px;">
      Mengetahui,
    </div>
    <div style="grid-row: 2; text-align: right;">
      Semarang, {{ $srt_pmhn_kmbali_biaya->tanggal_surat }}
    </div>
    <div style="grid-row: 3; text-align: center; display: flex; flex-direction: column; justify-content: center;">
      <div style="margin-bottom: 1rem;">
        <img src="{{ public_path($qrCodePath) }}" alt="QR Code" />
      </div>
      <div>
        <table
          style="
            text-align: justify;
            font-size: 12px;
            font-family: 'Times New Roman', Times, serif;
            width: 100%;
            border-collapse: collapse;
          "
        >
          <tr>
            <td style="padding-right: 100px;">a.n Dekan</td>
            <td></td>
          </tr>
          <tr>
            <td style="padding-right: 100px;">Wakil Dekan Sumber Daya</td>
            <td style="padding-bottom: 1rem">Pemohon</td>
          </tr>
          <tr>
            <td style="padding-right: 100px;">Dr. Warsito Kawedar, S.E., M.Si., Akt.</td>
            <td>{{ $srt_pmhn_kmbali_biaya->nama_mhw }}</td>
          </tr>
          <tr>
            <td style="padding-right: 100px;">NIP. 197405101998021001</td>
            <td>NIM. {{ $srt_pmhn_kmbali_biaya->nmr_unik }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <br>
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    "
  >
    Tembusan:
  </p>
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
      margin-left: 1rem;
    "
  >
    1. Bagian Keuangan Rektorat Undip
  </p>
</div>
@endsection
