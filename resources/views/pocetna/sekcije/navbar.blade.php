<!-- Navbar za početnu stranicu -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="main-navbar">
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
                    <a class="nav-link" href="#kontakt">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="btn button-primary" href="{{ route('login') }}">
                         Prijava
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
document.addEventListener('scroll', function () {
    document.getElementById('main-navbar').classList.toggle('navbar-scrolled', window.scrollY > 10);
});
</script>