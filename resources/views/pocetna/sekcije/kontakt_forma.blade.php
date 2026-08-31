<section id="kontakt" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card">
                <div class="card-body p-4">
                <h2 class="text-center mb-2">Kontaktirajte nas</h2>
                <p class="text-center text-muted mb-4">Imate pitanje? Pošaljite nam poruku i odgovorićemo što pre.</p>

                @if(session('kontakt_success'))
                    <div class="alert alert-success text-center">
                        Poruka je uspešno poslata! Odgovorićemo vam u najkraćem roku.
                    </div>
                @endif

                <form action="{{ route('kontakt.posalji') }}" method="POST" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-text
                                name="ime"
                                label="Ime i prezime"
                                placeholder="Vaše ime i prezime"
                                :required="true"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-input-text
                                name="email"
                                label="Email adresa"
                                placeholder="vas@email.com"
                                :required="true"
                            />
                        </div>
                    </div>

                    <x-input-text
                        name="telefon"
                        label="Broj telefona"
                        placeholder="+381 60 000 0000"
                    />

                    <x-input-textarea
                        name="poruka"
                        label="Poruka"
                        :required="true"
                    />

                    <div class="text-end mt-3">
                        <button type="submit" class="btn button-primary px-4">Pošalji poruku</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
