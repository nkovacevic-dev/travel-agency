@extends('layouts.app')
@section('content')

@include('includes.navbar')
@include('pocetna.slider')

<section class="py-5" id="putovanja">
    <div class="container">
        <h2 class="mb-4">Putovanja</h2>

        {{-- 3 kartice u redu --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($putovanja as $putovanje)
            <div class="col">
                <div class="card h-100 shadow-sm">

                    {{-- Slika --}}
                    @if($putovanje->slika)
                    <img src="{{ asset('storage/' . $putovanje->slika) }}" class="card-img-top" alt="{{ $putovanje->naziv }}">
                    @else
                    <img src="{{ asset('images/alps.png') }}" class="card-img-top" alt="{{ $putovanje->naziv }}">
                    @endif

                    {{-- Sadržaj kartice --}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $putovanje->naziv }}</h5>
                        <p class="card-text fw-bold text-primary">{{ number_format($putovanje->cena, 2) }} €</p>
                    </div>

                    {{-- Footer sa dugmetom --}}
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('putovanja.show', $putovanje->id) }}" class="btn button-primary w-100">Detalji</a>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection