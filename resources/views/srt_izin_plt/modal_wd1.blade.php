<div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('srt_izin_plt.tolak_wd1', $srt_izin_plt->id) }}" method="POST" id="tolakForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="catatan_surat" class="form-label">Alasan Surat Ditolak</label>
                        <textarea class="form-control" id="catatan_surat" name="catatan_surat" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tolakForm').addEventListener('submit', function(e) {
        let textarea = document.getElementById('catatan_surat');
        let suffix = " - Wakil Dekan 1";

        if (!textarea.value.includes(suffix)) {
            textarea.value += suffix;
        }
    });
</script>
