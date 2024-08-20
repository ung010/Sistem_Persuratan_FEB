<!-- Mood and Feedback Modal -->
<div class="modal fade" id="moodModal" tabindex="-1" aria-labelledby="moodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moodModalLabel">Survei Kepuasan Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Hidden input for selected mood -->
                <input type="hidden" id="selectedMood" name="selectedMood" value="">

                <div class="d-flex justify-content-around mb-4">
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/sangat puas.png') }}" alt="Sangat Puas" class="p-2 mood-img"
                            data-mood="sangat_puas" style="width: 60px; height: 60px;">
                        <p>SANGAT PUAS</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/puas.png') }}" alt="Puas" class="p-2 mood-img" data-mood="puas"
                            style="width: 60px; height: 60px;">
                        <p>PUAS</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/netral.png') }}" alt="Netral" class="p-2 mood-img"
                            data-mood="netral" style="width: 60px; height: 60px;">
                        <p>NETRAL</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/kurang puas.png') }}" alt="Kurang Puas" class="p-2 mood-img"
                            data-mood="kurang_puas" style="width: 60px; height: 60px;">
                        <p>KURANG PUAS</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/tidak puas.png') }}" alt="Tidak Puas" class="p-2 mood-img"
                            data-mood="tidak_puas" style="width: 60px; height: 60px;">
                        <p>TIDAK PUAS</p>
                    </div>
                </div>

                <div class="mb-3 d-flex flex-column justify-content-center gap-2 align-items-center">
                    <label for="comments" class="justify-content-center">Kritik dan Saran</label>
                    <textarea class="form-control w-50" id="feedback" rows="5" placeholder="Type Something Here..."></textarea>
                </div>

                <div class="d-flex justify-content-center align-items-center mb-3">
                    <button type="button" class="btn btn-warning" id="nextButton">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Survey Modal -->
<div class="modal fade" id="surveyModal" tabindex="-1" aria-labelledby="surveyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="surveyModalLabel">Survey Kepuasan Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="surveyForm" action="{{ route('survey.mahasiswa_create') }}" method="POST">
                    @csrf
                    <!-- Include hidden input for selected mood -->
                    <input type="hidden" id="hiddenMood" name="rating" value="">
                    <input type="hidden" id="hiddenFeedback" name="feedback" value="">

                    <!-- Example Survey Question -->
                    <div class="mb-3">
                        <label class="form-label">1. Bagaimana pendapat Saudara tentang kesesuaian persyaratan
                            pelayanan dengan jenis pelayanan?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="q1a"
                                value="Sangat Sesuai" required>
                            <label class="form-check-label" for="q1a">Sangat Sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="q1b"
                                value="Sesuai" required>
                            <label class="form-check-label" for="q1b">Sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="q1c"
                                value="Kurang Sesuai" required>
                            <label class="form-check-label" for="q1c">Kurang Sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question1" id="q1d"
                                value="Tidak Sesuai" required>
                            <label class="form-check-label" for="q1d">Tidak Sesuai</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">2. Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan
                            di
                            unit ini?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="q2a"
                                value="Sangat Mudah" required>
                            <label class="form-check-label" for="q2a">Sangat Mudah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="q2b"
                                value="Mudah" required>
                            <label class="form-check-label" for="q2b">Mudah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="q2c"
                                value="Kurang Mudah" required>
                            <label class="form-check-label" for="q2c">Kurang Mudah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question2" id="q2d"
                                value="Tidak Mudah" required>
                            <label class="form-check-label" for="q2d">Tidak Mudah</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">3. Bagaimana pendapat saudara tentang kecepatan waktu dalam
                            memberikan
                            pelayanan?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="q3a"
                                value="Sangat Cepat" required>
                            <label class="form-check-label" for="q3a">Sangat Cepat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="q3b"
                                value="Cepat" required>
                            <label class="form-check-label" for="q3b">Cepat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="q3c"
                                value="Kurang Cepat" required>
                            <label class="form-check-label" for="q3c">Kurang Cepat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question3" id="q3d"
                                value="Tidak Cepat" required>
                            <label class="form-check-label" for="q3d">Tidak Cepat</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">4. Bagaimana pendapat saudara tentang kewajaran biaya/tarif dalam
                            pelayanan?</label>
                        <div class="form-check" required>
                            <input class="form-check-input" type="radio" name="question4" id="q4a"
                                value="Gratis">
                            <label class="form-check-label" for="q4a">Gratis</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="q4b"
                                value="Murah" required>
                            <label class="form-check-label" for="q4b">Murah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="q4c"
                                value="Cukup Mahal" required>
                            <label class="form-check-label" for="q4c">Cukup Mahal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question4" id="q4d"
                                value="Sangat Mahal" required>
                            <label class="form-check-label" for="q4d">Sangat Mahal</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">5. Bagaimana pendapat saudara tentang kesesuaian produk pelayanan
                            antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question5" id="q5a"
                                value="Sangat Sesuai" required>
                            <label class="form-check-label" for="q5a">Sangat Sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question5" id="q5b"
                                value="Sesuai" required>
                            <label class="form-check-label" for="q5b">Sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question5" id="q5c"
                                value="Kurang Sesuai" required>
                            <label class="form-check-label" for="q5c">Kurang Sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question5" id="q5d"
                                value="Tidak Sesuai" required>
                            <label class="form-check-label" for="q5d">Tidak Sesuai</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">6. Bagaimana pendapat saudara tentang kompetensi/ kemampuan petugas
                            dalam pelayanan?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question6" id="q6a"
                                value="Sangat Kompeten" required>
                            <label class="form-check-label" for="q6a">Sangat Kompeten</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question6" id="q6b"
                                value="Kompeten" required>
                            <label class="form-check-label" for="q6b">Kompeten</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question6" id="q6c"
                                value="Kurang Kompeten" required>
                            <label class="form-check-label" for="q6c">Kurang Kompeten</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question6" id="q6d"
                                value="Tidak Kompeten" required>
                            <label class="form-check-label" for="q6d">Tidak Kompeten</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">7. Bagaimana pendapat saudara tentang perilaku petugas dalam
                            pelayanan terkait kesopanan dan keramahan?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question7" id="q7a"
                                value="Sangat Sopan dan Ramah" required>
                            <label class="form-check-label" for="q7a">Sangat Sopan dan Ramah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question7" id="q7b"
                                value="Sopan dan Ramah" required>
                            <label class="form-check-label" for="q7b">Sopan dan Ramah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question7" id="q7c"
                                value="Kurang Sopan dan Ramah" required>
                            <label class="form-check-label" for="q7c">Kurang Sopan dan Ramah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question7" id="q7d"
                                value="Tidak Sopan dan Ramah" required>
                            <label class="form-check-label" for="q7d">Tidak Sopan dan Ramah</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">8. Bagaimana pendapat saudara tentang kualitas sarana dan
                            prasarana?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question8" id="q8a"
                                value="Sangat Baik" required>
                            <label class="form-check-label" for="q8a">Sangat Baik</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question8" id="q8b"
                                value="Baik" required>
                            <label class="form-check-label" for="q8b">Baik</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question8" id="q8c"
                                value="Cukup" required>
                            <label class="form-check-label" for="q8c">Cukup</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question8" id="q8d"
                                value="Buruk" required>
                            <label class="form-check-label" for="q8d">Buruk</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">9. Bagaimana pendapat saudara tentang penanganan pengaduan pengguna
                            layanan??</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question9" id="q9a"
                                value="Dikelola dengan Baik" required>
                            <label class="form-check-label" for="q9a">Dikelola dengan Baik</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question9" id="q9b"
                                value="Berfungsi Kurang Maksimal" required>
                            <label class="form-check-label" for="q9b">Berfungsi Kurang Maksimal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question9" id="q9c"
                                value="Ada tetapi Tidak Berfungsi" required>
                            <label class="form-check-label" for="q9c">Ada tetapi Tidak Berfungsi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question9" id="q9d"
                                value="Tidak Ada" required>
                            <label class="form-check-label" for="q9d">Tidak Ada</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mood and Feedback Modal -->
<div class="modal fade" id="doneModal" tabindex="-1" aria-labelledby="doneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doneModalLabel">Survei Kepuasan Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Hidden input for selected mood -->
                <h1>Anda sudah mengisi survei sebelumnya.</h1>
            </div>
        </div>
    </div>
</div>
