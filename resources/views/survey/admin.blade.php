@extends('template/admin')
@section('inti_data')
    <h1>Halaman Admin - Survey</h1>
    <p>Berikut adalah hasil survey dari para pengguna:</p>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Sangat Puas</h5>
                    <p class="card-text">{{ $sangat_puas }} responden</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Puas</h5>
                    <p class="card-text">{{ $puas }} responden</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Netral</h5>
                    <p class="card-text">{{ $netral }} responden</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Kurang Puas</h5>
                    <p class="card-text">{{ $kurang_puas }} responden</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Tidak Puas</h5>
                    <p class="card-text">{{ $tidak_puas }} responden</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Feedback dari Pengguna</h3>
    <div id="feedback-container" class="list-group">
        @foreach ($feedbacks as $feedback)
            <div class="list-group-item feedback-item">
                <h5 class="mb-1">{{ $feedback->nama_mhw }}</h5>
                <p class="mb-1">{{ $feedback->feedback }}</p>
                <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($feedback->tanggal_surat)->format('d F Y') }}</small>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let feedbackItems = document.querySelectorAll('.feedback-item');
            let visibleFeedbackCount = 4; // Jumlah feedback yang terlihat sekaligus
            let currentIndex = 0;

            function showFeedbackItems() {
                // Sembunyikan semua feedback
                feedbackItems.forEach((item, index) => {
                    item.style.display = 'none';
                });

                // Tampilkan hanya 4 feedback yang diperlukan
                for (let i = 0; i < visibleFeedbackCount; i++) {
                    let feedbackIndex = (currentIndex + i) % feedbackItems.length;
                    feedbackItems[feedbackIndex].style.display = 'block';
                }

                // Update index untuk rotasi berikutnya
                currentIndex = (currentIndex + visibleFeedbackCount) % feedbackItems.length;
            }

            // Tampilkan pertama kali
            showFeedbackItems();

            // Ganti feedback setiap 3 detik
            setInterval(showFeedbackItems, 5000);
        });
    </script>
@endsection
