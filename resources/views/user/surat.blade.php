<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Surat</title>
</head>

<body>
    <div
        style="
        margin-right: auto;
        margin-left: auto;
        padding-top: 1rem;
        padding-bottom: 1rem;
        padding-left: 3rem;
        padding-right: 3rem;
      ">
        <table style="width: 100%; vertical-align: center;">
            <td style="vertical-align: center">
                <table>
                    <td style="padding-right: 1rem; vertical-align: center;">
                        <img src="{{ public_path('asset/logo.png') }}" alt="logo" style="width: 100px" />
                    </td>
                    <td style="vertical-align: center; padding-top: 20px;">
                        <div>
                            <p
                                style="
                    font-size: 12px;
                    margin: 0;
                    font-family: 'Times New Roman', Times, serif;
                  ">
                                KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,
                            </p>
                            <p
                                style="
                    font-size: 12px;
                    margin: 0;
                    font-family: 'Times New Roman', Times, serif;
                  ">
                                RISET, DAN TEKNOLOGI
                            </p>
                            <p
                                style="
                    font-size: 16px;
                    margin: 0;
                    font-family: 'Times New Roman', Times, serif;
                  ">
                                UNIVERSITAS DIPONEGORO
                            </p>
                            <p
                                style="
                    font-size: 14px;
                    margin: 0;
                    font-family: 'Times New Roman', Times, serif;
                  ">
                                KFAKULTAS EKONOMIKA DAN BISNIS
                            </p>
                        </div>
                    </td>
                </table>
            </td>
            <td style="vertical-align: center;">
                <div style="padding-top: 30px;">
                    <p
                        style="
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
                text-align: right;
                margin: 0;
              ">
                        Jalan Prof. Moeljono S. Trastotenojo
                    </p>
                    <p
                        style="
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
                text-align: right;
                margin: 0;
              ">
                        Kampus Universitas Diponegoro
                    </p>
                    <p
                        style="
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
                text-align: right;
                margin: 0;
              ">
                        Tembalang Semarang, Kode Pos 50275
                    </p>
                    <p
                        style="
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
                text-align: right;
                margin: 0;
              ">
                        Telepon (024) 76486841, 76486843
                    </p>
                    <p
                        style="
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
                text-align: right;
                margin: 0;
              ">
                        Laman: www.feb.undip.ac.id
                    </p>
                    <p
                        style="
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
                text-align: right;
                margin: 0;
              ">
                        Pos-el: feb[at]live.undip.ac.id
                    </p>
                </div>
            </td>
        </table>
        <br />
        @yield('content')
    </div>
</body>

</html>
