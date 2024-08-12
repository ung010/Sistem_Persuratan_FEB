@extends('user.layout')

@section('content')
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"
        style="margin-top: 1%; margin-left: 5%; margin-right: 5%;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://via.placeholder.com/800x400?text=First+Slide" class="d-block w-100" alt="First Slide">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/800x400?text=Second+Slide" class="d-block w-100" alt="Second Slide">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/800x400?text=Third+Slide" class="d-block w-100" alt="Third Slide">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="d-flex justify-content-end p-3">
        <button type="button" class="btn btn-primary rounded-circle" data-bs-toggle="modal"
            data-bs-target="{{ $existingSurvey ? '#doneModal' : '#moodModal' }}" style="width: 60px; height: 60px">
            <i class="fa fa-list-ul" style="font-size: 32px; color: white;"></i>
        </button>
    </div>

    @include('mahasiswa.modal')
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.mood-img').on('click', function() {
                $('.mood-img').removeClass('selected');

                // Add 'selected' class to the clicked mood option
                $(this).addClass('selected');
                var mood = $(this).data('mood');
                $('#selectedMood').val(mood);
                console.log('Selected mood: ' + mood); // For debugging
            });

            $('#nextButton').on('click', function() {
                // Pass the selected mood to the second modal
                $('#hiddenMood').val($('#selectedMood').val());
                $('#hiddenFeedback').val($('#feedback').val());
                $('#moodModal').modal('hide');
                $('#surveyModal').modal('show');
            });
        });
    </script>
@endsection
