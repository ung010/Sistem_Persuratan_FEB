@extends('template/dasar2')
@section('inti_data')

    <head>
        <title>Manage Akun Mahasiswa Belum di approve</title>
    </head>

    <body>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Verifikasi User</h1>
            {{-- <form id="ApproveAllForm" onsubmit="return confirm('Yakin ingin meng-approve semua akun?')" action="{{ url('/admin/mahasiswa/ApproveAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">Approve Semua</button>
            </form> --}}
            <form action="{{ route('admin.verif.search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari..." class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Cari</button>
            </form>
            <a href="/admin/verif_user" class="btn btn-primary">Reload</a>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        {{-- <th class="col-md-1">
                            <input class="form-check-input" type="checkbox" id="checkAll">
                        </th> --}}
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">NIM</th>
                        <th class="col-md-1">Departemen</th>
                        <th class="col-md-1">Program Studi</th>
                        <th class="col-md-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            {{-- <td>
                                <input class="form-check-input checkItem" type="checkbox" value="{{ $item->id }}">
                            </td> --}}
                            {{-- <td>
                                @if ($item->foto)
                                    <img style="max-width:50px;max-height:50px"
                                        src="{{ url('storage\foto\mahasiswa') . '/' . $item->foto }}" />
                                @endif
                            </td> --}}
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nmr_unik }}</td>                            
                            <td>{{ $item->nama_dpt }}</td>
                            <td>{{ $item->jenjang_prodi }}</td>
                            <td>
                                {{-- <form action="{{ url('/admin/mahasiswa/nonApprove/' . $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Non-Approve</button>
                                </form> --}}
                                <a href='{{ url('/admin/verif_user/cekdata/'.$item->id) }}' class="btn btn-warning btn-sm">Cek Data</a>
                            </td>
                            {{-- <td>
                            <a href='{{ url('/buku/update_admin/edit/'.$item->kode_gabungan_final) }}' class="btn btn-warning btn-sm">Edit</a>
                            
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="/admin" class="btn btn-primary">Kembali</a>
            <script>
                document.getElementById('checkAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('.checkItem');
                    for (var checkbox of checkboxes) {
                        checkbox.checked = this.checked;
                    }
                });
            </script>

            {{-- <!-- Form untuk mengirimkan ID yang dipilih -->
            <form id="bulkApproveForm" action="{{ url('/admin/mahasiswa/bulkApprove') }}" method="POST">
                @csrf
                <input type="hidden" name="selected_ids" id="selected_ids">
                <button type="button" class="btn btn-primary" onclick="submitBulkApprove()">Approve
                    Semua</button>
            </form> --}}

            <!-- Tambahkan JavaScript -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                document.getElementById('checkAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('.checkItem');
                    for (var checkbox of checkboxes) {
                        checkbox.checked = this.checked;
                    }
                });

                function submitBulkApprove() {
                    var selectedIds = [];
                    var checkboxes = document.querySelectorAll('.checkItem:checked');
                    for (var checkbox of checkboxes) {
                        selectedIds.push(checkbox.value);
                    }

                    if (selectedIds.length === 0) {
                        alert('Silakan pilih setidaknya satu akun untuk di approve.');
                        return;
                    }

                    document.getElementById('selected_ids').value = selectedIds.join(',');
                    document.getElementById('bulkApproveForm').submit();
                }
            </script>

            {{ $data->withQueryString()->links() }}
        </div>
    </body>
@endsection
