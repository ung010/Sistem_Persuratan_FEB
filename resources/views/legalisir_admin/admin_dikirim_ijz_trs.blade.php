@extends('template/admin')
@section('inti_data')

    <head>
        <title>Admin - Surat Keterangan mahasiswa bagi anak ASN</title>
    </head>

    <body>
        <a class="btn btn-primary" href="/legalisir/admin/dikirim/ijazah">Ijazah</a>
        <a class="btn btn-primary" href="/legalisir/admin/dikirim/transkrip">Transkrip</a>
        <a class="btn btn-primary" href="/legalisir/admin/dikirim/ijz_trs">Ijazah dan Transkrip</a>
        <form method="GET" action="{{ route('legalisir_admin.admin_dikirim_ijz_trs_search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/legalisir/admin/dikirim/ijz_trs">Reload</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Cek Data</th>
                        <th class="col-md-1">Status</th>
                        <th class="col-md-1">Unduh</th>
                        <th class="col-md-1">No Resi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama_mhw }}</td>
                            <td>
                                @if ($item->role_surat == 'admin')
                                    <a href="{{ url('/legalisir/admin/dikirim/ijz_trs/cek_legal/' . $item->id) }}"
                                        class="btn btn-warning btn-sm">Cek Data</a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Cek Data</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'admin')
                                    Verif Admin
                                @elseif ($item->role_surat == 'supervisor_akd')
                                    Verif Supervisor Akademik
                                @elseif ($item->role_surat == 'manajer')
                                    Verif Manajer
                                @elseif ($item->role_surat == 'manajer_sukses')
                                    Manajer telah verifikasi
                                @else
                                    Ditolak
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'manajer_sukses')
                                    <a href="{{ url('/legalisir/admin/dikirim/ijz_trs/download/' . $item->id) }}" class="btn btn-primary btn-sm">
                                        Unduh
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'manajer_sukses')
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#uploadModal" data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama_mhw }}">
                                        No Resi
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>No Resi</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->withQueryString()->links() }}

        <!-- Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">No Resi Pengiriman</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ isset($item) ? route('legalisir_admin.admin_dikirim_ijz_trs_resi', $item->id) : '#' }}"
                        method="POST" id="uploadForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="no_resi">No Resi</label>
                                <input type="text" class="form-control" id="no_resi" name="no_resi" required>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="diambil_ditempat"
                                    name="diambil_ditempat">
                                <label class="form-check-label" for="diambil_ditempat">Diambil Ditempat</label>
                            </div>
                            <input type="hidden" id="id" name="id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script>
            $('#uploadModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);

                modal.find('#id').val(id);
                modal.find('form').attr('action', '/legalisir/admin/dikirim/ijz_trs/no_resi/' + id);

                $('#diambil_ditempat').change(function() {
                    if (this.checked) {
                        $('#no_resi').val('Diambil Ditempat');
                        $('#no_resi').prop('disabled', true);
                    } else {
                        $('#no_resi').val('');
                        $('#no_resi').prop('disabled', false);
                    }
                });
            });
        </script>
    @endsection
