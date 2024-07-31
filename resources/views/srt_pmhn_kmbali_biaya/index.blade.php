@extends('template/mahasiswa')
@section('inti_data')

    <head>
        <title>
            Surat Keterangan mahasiswa bagi anak ASN
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_pmhn_kmbali_biaya.search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_pmhn_kmbali_biaya">Reload</a>
        <a class="btn btn-primary btn-sm">Tambah surat</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Departemen</th>
                        <th class="col-md-1">Program Studi</th>
                        <th class="col-md-1">Alamat / No HP</th>
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
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nmr_unik }}</td>
                            <td>
                                {{ $item->nama_dpt }}
                            </td>
                            <td>{{ $item->jenjang_prodi }}</td>
                            <td>
                                {{ $item->almt_asl }} / {{ $item->nowa }}
                            </td>
                            <td>
                                {{ $item->role_surat }}
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ url('/srt_pmhn_kmbali_biaya/edit/' . $item->id) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <a href="{{ url('/srt_pmhn_kmbali_biaya/download/' . $item->id) }}"
                                        class="btn btn-primary btn-sm">Unduh</a>
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

                    <form action="{{ route('srt_pmhn_kmbali_biaya.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="nama_mhw">Nama Mahasiswa:</label>
                            <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                        </div>
                        <br>
                        <div>
                            <label for="nmr_unik">NIM:</label>
                            <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                        </div>
                        <br>
                        <div>
                            <label for="ttl">Tempat Tanggal Lahir:</label>
                            <input type="text" id="ttl" name="ttl" value="{{ $kota_tanggal_lahir }}" readonly>
                        </div>
                        <br>
                        <div>
                            <label for="nowa">Alamat Asal:</label>
                            <input type="text" id="nowa" name="nowa" value="{{ $user->almt_asl }}" readonly>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="skl" class="form-label">SKL:</label>
                            <input type="file" name="skl" id="skl" class="form-control" required>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="bukti_bayar" class="form-label">Bukti Bayar:</label>
                            <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" required>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="buku_tabung" class="form-label">Buku Tabungan:</label>
                            <input type="file" name="buku_tabung" id="buku_tabung" class="form-control" required>
                        </div>
                        <br>
                        <div>
                            <label for="nama_dpt">Departemen:</label>
                            <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}"
                                readonly>
                        </div>
                        <br>
                        <div>
                            <label for="jenjang_prodi">Program Studi:</label>
                            <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}"
                                readonly>
                        </div>
                        <br>
                        <div>
                            <label for="nowa">Nomor Whatsapp:</label>
                            <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                        </div>
                        <br>
                        <div>
                            <button type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

@endsection
