<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="Generator" content="Microsoft Word 15 (filtered)">
    <title>DEPARTEMEN PENDIDIKAN NASIONAL</title>
    <style>
        @font-face {
            font-family: Wingdings;
            panose-1: 5 0 0 0 0 0 0 0 0 0;
        }

        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        p.MsoNormal,
        li.MsoNormal,
        div.MsoNormal {
            margin: 0in;
            font-size: 12.0pt;
            font-family: "Times New Roman", serif;
        }

        p.MsoHeader,
        li.MsoHeader,
        div.MsoHeader {
            margin: 0in;
            font-size: 12.0pt;
            font-family: "Times New Roman", serif;
        }

        span.HeaderChar {
            font-size: 10.0pt;
        }

        @page WordSection1 {
            size: 8.5in 11.0in;
            margin: 111.55pt .75in 35.95pt 63.0pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        ol {
            margin-bottom: 0in;
        }

        ul {
            margin-bottom: 0in;
        }
    </style>
</head>

<body lang=EN-US link=blue vlink="#954F72" style='word-wrap:break-word'>

    <div class=WordSection1>
        Manajer
        
        No Surat                : {{ $srt_masih_mhw->no_surat}}<br>
        Nama                    : {{ $srt_masih_mhw->nama_mhw}}<br>
        Tempat Tanggal Lahir    : {{ $srt_masih_mhw->ttl}}<br>
        NIM                     : {{ $srt_masih_mhw->nmr_unik}}<br>
        Alamat Rumah            : {{ $srt_masih_mhw->almt_smg}}<br>
        Departemen              : {{ $srt_masih_mhw->nama_dpt}}<br>
        Tahun Ajaran            : {{ $srt_masih_mhw->thn_awl}} / {{ $srt_masih_mhw->thn_akh}}<br>
        Keperluan               : {{ $srt_masih_mhw->tujuan_buat_srt}}<br>
        Semarang, {{ $srt_masih_mhw->tanggal_surat}}<br>
        

        <div>
            <img src="{{ public_path($qrCodePath) }}" alt="QR Code">
        </div>
    </div>

</body>

</html>
