<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="Generator" content="Microsoft Word 15 (filtered)">
    <title>Surat Magang</title>
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

            No Surat                    : {{ $srt_izin_plt->no_surat}}<br>
            Yth                         : {{ $srt_izin_plt->jbt_lmbg}}<br>
            Nama                        : {{ $srt_izin_plt->nama_mhw}}<br>
            NIM                         : {{ $srt_izin_plt->nmr_unik}}<br>
            Departemen/Program Studi    : {{ $srt_izin_plt->nama_dpt}} / {{ $srt_izin_plt->jenjang_prodi }}<br>
            Alamat Rumah                : {{ $srt_izin_plt->almt_asl}}<br>
            Judul Program               : {{ $srt_izin_plt->judul_data}}<br>
            Alamat Email                : {{ $srt_izin_plt->email}}<br>
            Semarang, {{ $srt_izin_plt->tanggal_surat}}<br>


        <div>
            <img src="{{ public_path($qrCodePath) }}" alt="QR Code">
        </div>
    </div>

</body>

</html>
