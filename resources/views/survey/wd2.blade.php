@extends('wd2.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-around my-5">
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/sangat puas.png') }}" alt="Sangat Puas" class="p-2 mood-img"
                            data-mood="Sangat Puas" style="width: 60px; height: 60px;">
                        <p>SANGAT PUAS</p>
                        <p>{{ $sangat_puas }}</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/puas.png') }}" alt="Puas" class="p-2 mood-img" data-mood="Puas"
                            style="width: 60px; height: 60px;">
                        <p>PUAS</p>
                        <p>{{ $puas }}</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/netral.png') }}" alt="Netral" class="p-2 mood-img" data-mood="Netral"
                            style="width: 60px; height: 60px;">
                        <p>NETRAL</p>
                        <p>{{ $netral }}</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/kurang puas.png') }}" alt="Kurang Puas" class="p-2 mood-img"
                            data-mood="Kurang Puas" style="width: 60px; height: 60px;">
                        <p>KURANG PUAS</p>
                        <p>{{ $kurang_puas }}</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 flex-column text-center">
                        <img src="{{ asset('asset/tidak puas.png') }}" alt="Tidak Puas" class="p-2 mood-img"
                            data-mood="Tidak Puas" style="width: 60px; height: 60px;">
                        <p>TIDAK PUAS</p>
                        <p>{{ $tidak_puas }}</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Kritik dan Saran Carousel -->
        <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($feedbacks->chunk(4) as $feedbackChunk)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <div class="d-flex gap-3 justify-content-between">
                            @foreach ($feedbackChunk as $feedback)
                                <div class="card flex-even">
                                    <div class="card-body d-flex flex-column gap-3 align-items-center align-content-center">
                                        <p>Kritik Dan Saran</p>
                                        <div class="card mb-3">
                                            <div class="card-header d-flex justify-content-center align-items-center align-content-center text-center">
                                                <p class="m-3">{{ strlen($feedback->feedback) > 100 ? substr($feedback->feedback, 0, 100) . '...' : $feedback->feedback }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <br>
        <!-- <div class="d-flex justify-content-end">
            <button class="btn btn-warning">Ambil Data Survey</button>
        </div> -->
    </div>
@endsection
