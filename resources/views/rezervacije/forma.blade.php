@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ $rezervacija->exists ? 'Izmena rezervacije' : 'Nova rezervacija' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $rezervacija->exists ? route('rezervacije.update', $rezervacija->id) : route('rezervacije.store') }}">
            @csrf
            @if($rezervacija->exists)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-4">
                    <x-input-text label="{{ __('Ime i prezime') }}" name="puno_ime" :value="$rezervacija->puno_ime ?? old('puno_ime')" :required="true" />
                </div>
                <div class="col-md-4">
                    <x-input-text label="{{ __('Email') }}" name="email" type="email" :value="$rezervacija->email ?? old('email')" :required="true" />
                </div>
                <div class="col-md-4">
                    <x-input-text label="{{ __('Telefon') }}" name="telefon" :value="$rezervacija->telefon ?? old('telefon')" :required="true" />
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-4">
                    <x-input-select label="{{ __('Putovanje') }}" name="id_putovanja" :items="$putovanja" :value="$rezervacija->id_putovanja ?? old('id_putovanja')" :emptyOption="true" :required="true" />
                </div>
                <div class="col-md-4">
                    <x-input-select label="{{ __('Termin') }}" name="id_termina" :items="$termini" :value="$rezervacija->id_termina ?? old('id_termina')" :emptyOption="true" :required="true" />
                </div>
                <div class="col-md-4">
                    <x-input-select label="{{ __('Hotel') }}" name="id_hotela" :items="$hoteli" :value="$rezervacija->id_hotela ?? old('id_hotela')" :emptyOption="true" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <x-input-select label="{{ __('Tip sobe') }}" name="id_tip_sobe" :items="$tip_sobe" :value="$rezervacija->id_tip_sobe ?? old('id_tip_sobe')" :emptyOption="true" />
                </div>
                <div class="col-md-4">
                    <x-input-text label="{{ __('Broj odraslih') }}" name="broj_odraslih" type="number" :value="$rezervacija->broj_odraslih ?? old('broj_odraslih', 1)" :required="true" min="1" />
                </div>
                <div class="col-md-4">
                    <x-input-text label="{{ __('Broj dece') }}" name="broj_dece" type="number" :value="$rezervacija->broj_dece ?? old('broj_dece', 0)" min="0" />
                </div>
            </div>

            @if(isset($rezervacija->id))
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="nova" {{ ($rezervacija->status ?? 'nova') == 'nova' ? 'selected' : '' }}>Nova</option>
                            <option value="potvrđena" {{ ($rezervacija->status ?? '') == 'potvrđena' ? 'selected' : '' }}>Potvrđena</option>
                            <option value="otkazana" {{ ($rezervacija->status ?? '') == 'otkazana' ? 'selected' : '' }}>Otkazana</option>
                        </select>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <x-input-textarea label="{{ __('Napomena') }}" name="napomena" :value="$rezervacija->napomena ?? old('napomena')" rows="3" />
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn button-primary">
                     {{ __('Sačuvaj') }}
                </button>
                <a href="{{ route('rezervacije.index') }}" class="btn button-outline-primary">
                     {{ __('Nazad') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('content_scripts')
<script>
    $(function () {
        function popuniSelectOpcije($select, opcije, trenutnaVrednost) {
            $select.empty().append('<option></option>');
            $.each(opcije, function (i, item) {
                $select.append(new Option(item.text, item.id, false, item.id == trenutnaVrednost));
            });
            $select.trigger('change');
        }

        $('#id_putovanja').on('change', function () {
            var idPutovanja = $(this).val();
            var trenutniTermin = $('#id_termina').val();
            var trenutniHotel  = $('#id_hotela').val();

            popuniSelectOpcije($('#id_termina'), [], null);
            popuniSelectOpcije($('#id_hotela'), [], null);

            if (!idPutovanja) return;

            $.get('/api/putovanja/' + idPutovanja + '/detalji', function (data) {
                popuniSelectOpcije($('#id_termina'), data.termini, trenutniTermin);
                popuniSelectOpcije($('#id_hotela'), data.hoteli, trenutniHotel || data.id_hotela);
            });
        });

        // Okini odmah ako je edit (putovanje već odabrano)
        @if(($rezervacija->id_putovanja ?? old('id_putovanja')))
            $('#id_putovanja').trigger('change');
        @endif
    });
</script>
@endsection
