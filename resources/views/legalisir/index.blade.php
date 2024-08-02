@extends('template/mahasiswa')
@section('inti_data')

    <head>
        <title>
            Surat Keterangan mahasiswa bagi anak ASN
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('legalisir.search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/legalisir">Reload</a>
        <a class="btn btn-primary btn-sm">Tambah surat</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Departemen</th>
                        <th class="col-md-1">Program Studi</th>
                        <th class="col-md-1">Alamat Tujuan</th>
                        <th class="col-md-1">Lacak (Role)</th>
                        <th class="col-md-1">Status (Role)</th>
                        <th class="col-md-1">No Resi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td> {{ $item->nama }}</td>
                            <td>{{ $item->nmr_unik }}</td>
                            <td>
                                {{ $item->nama_dpt }}
                            </td>
                            <td>{{ $item->jenjang_prodi }}</td>
                            <td>{{ $item->almt_kirim }}</td>
                            <td>
                                {{ $item->role_surat }}
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ url('/legalisir/edit/' . $item->id) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                {{$item->no_resi}}
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

                    <form action="{{ route('legalisir.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="jenis_lgl">Jenis Legalisir:</label>
                            <select name="jenis_lgl" id="jenis_lgl" required>
                                <option value="">Select Option</option>
                                <option value="ijazah">Ijazah</option>
                                <option value="transkrip">Transkrip</option>
                                <option value="ijazah_transkrip">Ijazah dan Transkrip</option>
                            </select>
                        </div>
                        <div>
                            <label for="nama_mhw">Nama Mahasiswa:</label>
                            <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                        </div>
                        <div>
                            <label for="nama_dpt">Departemen:</label>
                            <input type="text" id="nama_dpt" name="nama_dpt" value="{{ $departemen->nama_dpt }}"
                                readonly>
                        </div>
                        <div>
                            <label for="almt_asl">Alamat Asal:</label>
                            <input type="text" id="almt_asl" name="almt_asl" value="{{ $user->almt_asl }}" readonly>
                        </div>
                        <div>
                            <label for="almt_smg">Alamat Tujuan Pengiriman:</label>
                            <input type="text" name="almt_smg" id="almt_smg">
                        </div>
                        <div>
                            <label for="kcmt_kirim">Kecamatan:</label>
                            <input type="text" name="kcmt_kirim" id="kcmt_kirim">
                        </div>
                        <div>
                            <label for="kdps_kirim">Kode Pos:</label>
                            <input type="number" name="kdps_kirim" id="kdps_kirim">
                        </div>
                        <div class="mb-3">
                            <label for="file_ijazah" class="form-label">File Ijazah:</label>
                            <input type="file" name="file_ijazah" id="file_ijazah" class="form-control">
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="file_transkrip" class="form-label">File Transkrip:</label>
                            <input type="file" name="file_transkrip" id="file_transkrip" class="form-control">
                        </div>
                        <div>
                            <label for="keperluan">Keperluan:</label>
                            <input type="text" name="keperluan" id="keperluan" required>
                        </div>
                        <div>
                            <label for="nmr_unik">NIM:</label>
                            <input type="number" id="nmr_unik" name="nmr_unik" value="{{ $user->nmr_unik }}" readonly>
                        </div>
                        <div>
                            <label for="jenjang_prodi">Program Studi:</label>
                            <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}"
                                readonly>
                        </div>
                        <div>
                            <label for="nowa">Nomor Whatsapp:</label>
                            <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                        </div>
                        <div>
                            <label for="tgl_lulus" class="form-label">Tanggal Lulus:</label>
                            <input type="date" name="tgl_lulus" id="tgl_lulus"
                                class="form-control" required>
                        </div>                        
                        <div>
                            <label for="ambil">Pengambilan:</label>
                            <select name="ambil" id="ambil" required>
                                <option value="">Select Option</option>
                                <option value="ditempat">Diambil Ditempat</option>
                                <option value="dikirim">Dikirim</option>
                            </select>
                        </div>
                        <div>
                            <label for="klh_kirim">Kelurahan:</label>
                            <input type="text" name="klh_kirim" id="klh_kirim">
                        </div>
                        <div>
                            <label for="kota_kirim">Kota/Kabupaten:</label>
                            <input type="text" name="kota_kirim" id="kota_kirim">
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </body>

@endsection
