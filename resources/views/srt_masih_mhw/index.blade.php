@extends('template/mahasiswa')
@section('inti_data')

    <head>
        <title>
            Surat Keterangan mahasiswa bagi anak ASN
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_masih_mhw.search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_masih_mhw">Reload</a>
        <a class="btn btn-primary btn-sm">Tambah surat</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Alamat</th>
                        <th class="col-md-1">Semester / Tahun Ajaran</th>
                        <th class="col-md-1">Tempat Tanggal Lahir</th>
                        <th class="col-md-1">Alasan Surat</th>
                        <th class="col-md-1">Lacak (Role)</th>
                        <th class="col-md-1">Status (Role)</th>
                        <th class="col-md-1">Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama_mhw }}</td>
                            <td>{{ $item->almt_smg }}</td>
                            <td>
                                {{$item->semester}}, {{ $item->thn_awl }}/{{ $item->thn_akh }}
                            </td>
                            <td>{{ $item->ttl }}</td>
                            <td>{{ $item->tujuan_buat_srt }}</td>
                            <td>
                                {{ $item->role_surat }}
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ url('/srt_masih_mhw/edit/' . $item->id) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    @if ($item->tujuan_akhir == 'manajer')
                                        <a href="{{ url('/srt_masih_mhw/manajer/download/' . $item->id) }}" class="btn btn-primary btn-sm">Unduh</a>
                                    @elseif ($item->tujuan_akhir == 'wd')
                                        <a href="{{ route('srt_masih_mhw.download_wd', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">Unduh</a>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                    @endif
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $data->withQueryString()->links() }}

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h2>Buat Surat Baru</h2>
            <div class="container py-5 login">
                <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('srt_masih_mhw.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="nama_mhw">Nama Mahasiswa:</label>
                            <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                        </div>
                        <div>
                            <label for="nmr_unik">NIM:</label>
                            <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                        </div>
                        <div>
                            <label for="nama_dpt">Departemen:</label>
                            <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}" readonly>
                        </div>
                        <div>
                            <label for="nama_jnjg">Jenjang Pendidikan:</label>
                            <input type="text" id="nama_jnjg" name="nama_jnjg" value="{{ $jenjang->nama_jnjg }}" readonly>
                        </div>
                        <div>
                            <label for="kota_tanggal_lahir">Tempat Tanggal Lahir:</label>
                            <input type="text" id="kota_tanggal_lahir" name="kota_tanggal_lahir" value="{{ $kota_tanggal_lahir }}" readonly>
                        </div>
                        <div>
                            <label for="thn_awl">Tahun Ajaran (Awal):</label>
                            <input type="number" name="thn_awl" id="thn_awl" required>
                        </div>
                        <div>
                            <label for="thn_akh">Tahun Ajaran (Akhir):</label>
                            <input type="number" name="thn_akh" id="thn_akh" required>
                        </div>
                        <div>
                            <label for="semester">Semester:</label>
                            <select name="semester" id="semester" required>
                                @for ($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="almt_smg">Alamat Semarang:</label>
                            <input type="text" id="almt_smg" name="almt_smg" id="almt_smg" required>
                        </div>
                        <div>
                            <label for="tujuan_buat_srt">Tujuan Pembuatan Surat:</label>
                            <input type="text" name="tujuan_buat_srt" id="tujuan_buat_srt" required>
                        </div>
                        <div>
                            <label for="nowa">Nomor Whatsapp:</label>
                            <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                        </div>
                        <h5>Pilih salah satu</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tujuan_akhir" value="manajer"
                                id="manajer" required>
                            <label class="form-check-label" for="manajer">
                                Manajer
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tujuan_akhir" value="wd" id="wd"
                                required>
                            <label class="form-check-label" for="wd">
                                Wakil Dekan Akademik
                            </label>
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </body>

@endsection
