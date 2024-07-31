@extends('template/mahasiswa')
@section('inti_data')

    <head>
        <title>
            Surat Keterangan mahasiswa bagi anak ASN
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_magang.search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_magang">Reload</a>
        <a class="btn btn-primary btn-sm">Tambah surat</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Instansi Tujuan</th>
                        <th class="col-md-1">Alamat Instansi</th>
                        <th class="col-md-1">Nama/NIM</th>
                        <th class="col-md-1">Semester</th>
                        <th class="col-md-1">Alamat/No HP</th>
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
                            <td>{{ $item->nama_lmbg }}</td>
                            <td>{{ $item->almt_lmbg }}</td>
                            <td>
                                {{ $item->nama }}/{{ $item->nmr_unik }}
                            </td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->almt_smg }} / {{ $item->nowa }}</td>
                            <td>
                                {{ $item->role_surat }}
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                    <a href="{{ url('/srt_magang/edit/' . $item->id) }}"
                                        class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <a href="{{ url('/srt_magang/download/' . $item->id) }}" class="btn btn-primary btn-sm">Unduh</a>
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

                    <form action="{{ route('srt_magang.store') }}" method="POST">
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
                            <label for="jenjang_prodi">Jenjang Pendidikan:</label>
                            <input type="text" id="jenjang_prodi" name="jenjang_prodi" value="{{ $jenjang_prodi }}" readonly>
                        </div>
                        <div>
                            <label for="nowa">Nomor Whatsapp:</label>
                            <input type="text" id="nowa" name="nowa" value="{{ $user->nowa }}" readonly>
                        </div>
                        <div>
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email" value="{{ $user->email }}" readonly>
                        </div>                        
                        <div>
                            <label for="almt_smg">Alamat Semarang:</label>
                            <input type="text" id="almt_smg" name="almt_smg" id="almt_smg" required>
                        </div>
                        <div>
                            <label for="semester">Semester:</label>
                            <input type="number" name="semester" id="semester" required>
                        </div>
                        <div>
                            <label for="ipk">IPK:</label>
                            <input type="string" name="ipk" id="ipk" required>
                        </div>
                        <div>
                            <label for="sksk">SKSK:</label>
                            <input type="number" name="sksk" id="sksk" required>
                        </div>
                        <div>
                            <label for="nama_lmbg">Lembaga yang Dituju:</label>
                            <input type="text" name="nama_lmbg" id="nama_lmbg" required>
                        </div>
                        <div>
                            <label for="jbt_lmbg">Jabatan Pimpinan yang Dituju:</label>
                            <input type="text" name="jbt_lmbg" id="jbt_lmbg" required>
                        </div>
                        <div>
                            <label for="kota_lmbg">Kota / Kabuaten Lembaga:</label>
                            <input type="text" name="kota_lmbg" id="kota_lmbg" required>
                        </div>
                        <div>
                            <label for="almt_lmbg">Alamat Lembaga:</label>
                            <input type="text" name="almt_lmbg" id="almt_lmbg" required>
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </body>

@endsection
