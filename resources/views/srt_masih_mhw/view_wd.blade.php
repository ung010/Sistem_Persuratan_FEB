@extends('user.surat') @section('content')
<table style="width: 100%; text-align: center">
  <tr>
    <td>
      <strong
        style="
          font-size: 16px;
          font-family: 'Times New Roman', Times, serif;
          text-align: justify;
        "
        ><u>SURAT KETERANGAN</u></strong
      >
    </td>
  </tr>
  <tr>
    <td>
      <p style="font-size: 12px; margin: 0">
        Nomor: {{ $srt_masih_mhw->no_surat }}
      </p>
    </td>
  </tr>
</table>
<br />
<div style="padding: 0 1rem 0 1rem">
  <p style="font-size: 12px; margin: 0; text-align: justify">
    Pimpinan Fakultas Ekonomika dan Bisnis Universitas Diponegoro Semarang
    menerangkan bahwa :
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
      <td>{{ $srt_masih_mhw->nama_mhw }}</td>
    </tr>
    <tr>
      <td>Tempat / Tanggal Lahir</td>
      <td>:</td>
      <td>{{ $srt_masih_mhw->ttl }}</td>
    </tr>
    <tr>
      <td>NIM</td>
      <td>:</td>
      <td>{{ $srt_masih_mhw->nmr_unik }}</td>
    </tr>
    <tr>
      <td>Departemen</td>
      <td>:</td>
      <td>{{ $srt_masih_mhw->nama_dpt }}</td>
    </tr>
    <tr>
      <td>Alamat Rumah</td>
      <td>:</td>
      <td>{{ $srt_masih_mhw->almt_smg }}</td>
    </tr>
    <tr>
      <td>No. Telp./HP</td>
      <td>:</td>
      <td>{{ $srt_masih_mhw->nowa }}</td>
    </tr>
  </table>
  <br />
  <p style="font-size: 12px; margin: 0; text-align: justify">
    Yang namanya tersebut di atas adalah benar – benar mahasiswa {{
    $srt_masih_mhw->nama_prd }} Fakultas Ekonomika dan Bisnis Universitas
    Diponegoro Semarang Tahun Akademik : {{ $srt_masih_mhw->thn_awl }} / {{
    $srt_masih_mhw->thn_akh }}
  </p>
  <br />
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    "
  >
    Surat keterangan ini dikeluarkan untuk keperluan :
  </p>
  <br />
  <p
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
    "
  >
    {{ $srt_masih_mhw->tujuan_buat_srt }}
  </p>
  <br />
  <table
    style="
      text-align: justify;
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
      width: 100%;
    "
  >
    <tr>
      <td style="padding-right: 300px;"></td>
      <td style="padding-bottom: 1rem;">
        Semarang, {{ $srt_masih_mhw->tanggal_surat }}
      </td>
    </tr>
    <tr>
      <td style="padding-right: 300px;">Yang berkepentingan</td>
      <td>an. Dekan,</td>
    </tr>
    <tr>
      <td style="padding-right: 300px;"></td>
      <td style="padding-bottom: 1rem">Wakil Dekan Akademik dan Kemahasiswaan,</td>
    </tr>
    <tr>
      <td style="padding-bottom: 1rem; padding-right: 300px;">
      </td>
      <td style="padding-bottom: 1rem;">
        <img src="{{ public_path($qrCodePath) }}" alt="QR Code" />
      </td>
    </tr>
    <tr>
      <td style="padding-right: 300px;">{{ $srt_masih_mhw->nama_mhw }}</td>
      <td>Prof. Firmansyah, SE., M.Si., Ph.D.</td>
    </tr>
    <tr>
      <td style="padding-right: 300px;">NIM. {{ $srt_masih_mhw->nmr_unik }}</td>
      <td>NIP. 197404271999031001</td>
    </tr>
  </table>
</div>
@endsection
