<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1920, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Yoklah University</title>
    <link href="{{ asset('css/bootstrap5.min.css') }}" rel="stylesheet">

    <style>
        .card-img-top {
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body style="overflow-x: hidden;">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg" style=">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/logo_yoklah_university.webp') }}" alt="Bootstrap" width="50"
                        height="50">
                    <span>Penerimaan Mahasiswa Baru</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        {{-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li> --}}
                    </ul>
                    @if (Route::has('login'))
                        @auth
                            <a class="btn btn-primary me-2" href="{{ route('home') }}">Dashboard</a>
                        @else
                            <a class="btn btn-outline-success me-2" href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                                <a class="btn btn-info" href="{{ route('register') }}">Daftar</a>
                            @endif
                        @endauth
                </div>
                @endif
            </div>
        </nav>
    </div>

    <div class="row">
        <div class="col">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="{{ asset('assets/images/banner_1.jpg') }}" class="d-block w-100"
                            alt="{{ asset('assets/images/banner_1.jpg') }}">
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('assets/images/banner_2.jpg') }}" class="d-block w-100"
                            alt="{{ asset('assets/images/banner_2.jpg') }}">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/images/banner_3.jpg') }}" class="d-block w-100"
                            alt="{{ asset('assets/images/banner_3.jpg') }}">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5" style="background-color: #FFFFFF !important;">
        <div class="row justify-content-center mx-5">
            <div class="card mb-3 shadow">
                <div class="card-body">
                    <h1 class="card-title text-center">Tunggu Apa Lagi!</h1>
                    <div class="d-flex justify-content-center mt-5">
                        <a class="btn btn-primary" href="{{ route('register') }}">DAFTAR SEKARANG</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5" style="background-color: #FFFFFF !important;">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-center">PENGUMUMAN</h1>
            </div>
            @foreach ($announcements as $ann)
                <div class="col-md-4 col-lg-3 mb-2">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset($ann->path) }}" class="card-img-top" alt="{{ $ann->title }}"
                            style="height: 300px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $ann->title }}</h5>

                            <p class="card-text" id="announcement-{{ $ann->id }}">
                                @php
                                    $description = nl2br(e($ann->description));
                                @endphp

                                <span class="truncated-text">
                                    @if (strlen($ann->description) > 50)
                                        {!! nl2br(e(substr($ann->description, 0, 50))) !!}...
                                    @else
                                        {!! $description !!}
                                    @endif
                                </span>
                                @if (strlen($ann->description) > 50)
                                    <span class="full-text" style="display:none;">
                                        {!! $description !!}
                                    </span>
                                    <a href="javascript:void(0)" class="see-more" style="display:inline;">See More</a>
                                    <a href="javascript:void(0)" class="see-less" style="display:none;">See Less</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container-fluid py-1" style="background-color: #FFFFFF !important;">
        <div class="row justify-content-center mx-5">
            <div class="col">
                <div class="card mb-3 shadow-sm justify-content-center">
                    <h1 class="text-center">About Us</h1>
                    <div class="card-body d-flex justify-content-center">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/lQYV3m1J4gs?si=c4ECVQldz2ZQsg_N&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-1" style="background-color: #FFFFFF !important;">
        <div class="row justify-content-center mx-5">
            <div class="col">
                <div class="card mb-3 shadow-sm justify-content-center">
                    <h1 class="text-center">You Can Find Us Here!</h1>
                    <div class="card-body d-flex justify-content-center">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15937.882070500256!2d104.74042730000001!3d-2.96686155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b76094fcf39dd%3A0x8b4ee43321ad20a0!2sMDP%20IT%20Superstore!5e0!3m2!1sen!2sid!4v1734010496046!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-2 d-flex align-items-center justify-content-center"
        style="min-height: 80px;">
        <p class="text-center text-black mb-0">
            Copyright © {{ now()->format('Y') }} Universitas Yoklah. All rights reserved.
        </p>
    </div>


    <script src="{{ asset('js/bootstrap5.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const seeMoreLinks = document.querySelectorAll('.see-more');
            const seeLessLinks = document.querySelectorAll('.see-less');

            seeMoreLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const cardText = this.closest('.card-body').querySelector('.card-text');
                    const truncatedText = cardText.querySelector('.truncated-text');
                    const fullText = cardText.querySelector('.full-text');
                    truncatedText.style.display = 'none';
                    fullText.style.display = 'inline';
                    this.style.display = 'none';
                    cardText.querySelector('.see-less').style.display = 'inline';
                });
            });

            seeLessLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const cardText = this.closest('.card-body').querySelector('.card-text');
                    const truncatedText = cardText.querySelector('.truncated-text');
                    const fullText = cardText.querySelector('.full-text');
                    fullText.style.display = 'none';
                    truncatedText.style.display = 'inline';
                    this.style.display = 'none';
                    cardText.querySelector('.see-more').style.display = 'inline';
                });
            });
        });
    </script>
</body>

</html>
