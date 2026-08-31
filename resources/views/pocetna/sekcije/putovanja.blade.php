<section class="py-5" id="putovanja">
    <div class="container">
        <h2 class="mb-4">Putovanja u ponudi</h2>

        {{-- 3 kartice u redu --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($putovanja as $index => $putovanje)
            <div class="col{{ $index >= 6 ? ' d-none extra-card' : '' }}">
                <a href="{{ route('putovanja.show', $putovanje->id) }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm card-hover">

                    @if($putovanje->slike->isNotEmpty())
                    <img src="{{ asset('storage/putovanja/' . $putovanje->id . '/slike/' . $putovanje->slike->first()->slika) }}" class="card-img-top" alt="{{ $putovanje->naziv }}">
                    @else
                    <img src="{{ asset('images/alps.png') }}" class="card-img-top" alt="{{ $putovanje->naziv }}">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $putovanje->naziv }}</h5>

                        @if($putovanje->termini->isNotEmpty())
                        <ul class="list-unstyled mb-2 small">
                            @foreach($putovanje->termini as $termin)
                            <li><i class="fa fa-calendar me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($termin->datum_od)->format('d.m.Y') }} &ndash; {{ \Carbon\Carbon::parse($termin->datum_do)->format('d.m.Y') }}
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        
                        
                        <p class="card-text fw-bold text-primary mb-0">{{ number_format($putovanje->cena, 2) }} €</p>
                        @if($putovanje->tipPrevoza)
                        <p class="small text-muted mt-2 mb-0">
                            <i class="fa fa-{{ strtolower($putovanje->tipPrevoza->naziv) === 'avion' ? 'plane' : 'bus' }} me-1"></i>
                            {{ $putovanje->tipPrevoza->naziv }}
                        </p>
                        @endif
                        
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <span class="btn button-primary w-100">Saznaj više</span>
                    </div>
                </div>
                </a>
            </div>
            @endforeach
        </div>

        @if($putovanja->count() > 6)
        <div class="row mt-4">
            <div class="col text-center">
                <h5 class="mb-3 text-muted">Zanimaju te i ostala putovanja?</h5>
                <button id="btn-prikazi-vise" class="btn button-primary px-5" onclick="prikaziVise()">Prikaži više</button>
            </div>
        </div>
        @endif
    </div>
</section>

<script>
function prikaziVise() {
    document.querySelectorAll('.extra-card').forEach(el => el.classList.remove('d-none'));
    document.getElementById('btn-prikazi-vise').closest('.row').remove();
}
</script>