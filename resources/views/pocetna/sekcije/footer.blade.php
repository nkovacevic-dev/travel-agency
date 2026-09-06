<footer class="guest-footer bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <img src="/images/logo-sidebar2.png" alt="Logo" style="height:50px;" class="mb-3">
                <p class="text-white-50 small">Vaš pouzdani partner za organizaciju putovanja. Nudimo širok izbor aranžmana prilagođenih svakom budžetu.</p>
            </div>
            <div class="col-md-4">
                <h6 class="fw-semibold mb-3">Brzi linkovi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1"><a href="{{ route('pocetna') }}" class="text-white-50 text-decoration-none">Početna</a></li>
                    <li class="mb-1"><a href="#putovanja" class="text-white-50 text-decoration-none">Putovanja</a></li>
                    <li class="mb-1"><a href="#kontakt" class="text-white-50 text-decoration-none">Kontakt</a></li>
                    <li class="mb-1"><a href="{{ route('login') }}" class="text-white-50 text-decoration-none">Prijava</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-semibold mb-3">Kontakt</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-1"><i class="fa fa-envelope me-2"></i> agencija@dev.nkovacevic.in.rs</li>
                    <li class="mb-1"><i class="fa fa-phone me-2"></i> +381 61/3210-123</li>
                    <li class="mb-1"><i class="fa fa-map-marker me-2"></i> Žarka Zrenjanina 1, Zrenjanin</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="text-center text-white-50 small mb-0">&copy; {{ date('Y') }} Agencija "BEYOND BORDERS". Sva prava zadržana.</p>
    </div>
</footer>
