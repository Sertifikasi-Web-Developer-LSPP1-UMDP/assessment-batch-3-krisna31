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

<body style="background-color: #FFFDD0 !important; overflow-x: hidden;">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg" style="background-color: #FFFDD0 !important;">
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
                        <a class="btn btn-primary" href="{{ route('register') }}">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5" style="background-color: #FFFFFF !important;">
        <div class="row justify-content-center">
            @foreach ($announcements as $ann)
                <div class="col-md-4 mb-2">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset($ann->path) }}" class="card-img-top" alt="{{ $ann->title }}"
                            style="height: 300px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $ann->title }}</h5>
                            <p class="card-text">{!! nl2br($ann->description) !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container-fluid mt-5 d-flex align-items-center justify-content-center"
        style="min-height: 40px; background-color: #FFFDD0 !important;">
        <p class="text-center text-black">Copyright © {{ now()->format('Y') }} Universitas
            Yoklah. All right reserved.</p>
    </div>

    <script src="{{ asset('js/bootstrap5.min.js') }}"></script>
</body>

</html>
