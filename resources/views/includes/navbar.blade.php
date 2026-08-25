<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo-placeholder">
            <img src="/images/logo-sidebar2.png" alt="Logo" class="logo logo-pocetna">
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('pocetna') }}">Početna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#putovanja">Putovanja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('login') }}">
                        <i class="fa fa-sign-in"></i> Prijavi se
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="/images/carousel-1.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Slider One Item</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="/images/carousel-2.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Slider One Item</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>