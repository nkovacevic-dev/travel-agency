@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ $putovanje->exists ? 'Izmena putovanja' : 'Novo putovanje' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $putovanje->exists ? route('putovanja.update', $putovanje->id) : route('putovanja.store') }}" enctype="multipart/form-data">
            @csrf
            @if($putovanje->exists)
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-6">
                    <x-input-text label="{{ __('Naziv') }}" name="naziv" :value="$putovanje->naziv ?? old('naziv')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-select label="{{ __('Država') }}" name="id_drzave" :items="$drzave" :value="$putovanje->id_drzave ?? old('id_drzave')" :emptyOption="true" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Grad') }}" name="grad" :value="$putovanje->grad ?? old('grad')" :required="true" />
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="label-select"><b>{{ __('Termini putovanja') }}</b></label>
                    <div id="termini-container"></div>
                    <button type="button" id="btn-dodaj-termin" class="btn btn-sm button-outline-primary">
                        {{ __('Dodaj termin') }}
                    </button>
                    @error('termini')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <x-input-text label="{{ __('Cena (EUR)') }}" name="cena" type="number" step="0.01" :value="$putovanje->cena ?? old('cena')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Broj dana') }}" name="broj_dana" type="number" :value="$putovanje->broj_dana ?? old('broj_dana')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Broj noćenja') }}" name="broj_nocenja" type="number" :value="$putovanje->broj_nocenja ?? old('broj_nocenja')" :required="true" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <x-input-select label="{{ __('Tip prevoza') }}" name="id_tip_prevoza" :items="$tip_prevoza" :value="$putovanje->id_tip_prevoza ?? old('id_tip_prevoza')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Prevoznik') }}" name="prevoznik" :value="$putovanje->prevoznik ?? old('prevoznik')" />
                </div>
                <div class="col-md-3">
                    <x-input-select label="{{ __('Hotel') }}" name="id_hotela" :items="$hoteli" :value="$putovanje->id_hotela ?? old('id_hotela')" :emptyOption="true" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <x-input-textarea label="{{ __('Program putovanja') }}" name="program_putovanja" :value="$putovanje->program_putovanja ?? old('program_putovanja')" rows="5" :required="true" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-input-textarea label="{{ __('Fakultativni izleti') }}" name="fakultativni_izleti" :value="$putovanje->fakultativni_izleti ?? old('fakultativni_izleti')" rows="5" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <x-input-textarea label="{{ __('Pravila otkazivanja') }}" name="pravila_otkazivanja" :value="$putovanje->pravila_otkazivanja ?? old('pravila_otkazivanja')" rows="3" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <x-input-file label="{{ __('Galerija slika') }}" name="galerija_slika" :multiple="true" :existing="$putovanje->galerija_slika ?? []" type="image/*" />
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn button-primary">
                    {{ __('Sačuvaj') }}
                </button>
                <a href="{{ route('putovanja.index') }}" class="btn button-outline-primary">
                    {{ __('Nazad') }}
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('content_scripts')
<script>
    var terminCount = 0;
    var fpOptions = { dateFormat: 'd.m.Y.', allowInput: false };

    function dodajTermin(datum_od, datum_do, broj_mesta) {
        var idx = terminCount++;
        var $row = $(`
            <div class="termin-row row mb-2 align-items-end" data-idx="${idx}">
                <div class="col-md-3">
                    <div class="form-field">
                        <label class="label-select">{{ __('Datum od') }} *</label>
                        <input type="text" name="termini[${idx}][datum_od]" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-field">
                        <label class="label-select">{{ __('Datum do') }} *</label>
                        <input type="text" name="termini[${idx}][datum_do]" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-field">
                        <label class="label-select">{{ __('Dostupna mesta') }} *</label>
                        <input type="number" name="termini[${idx}][broj_dostupnih_mesta]" class="form-control" min="1" value="${broj_mesta ?? ''}">
                    </div>
                </div>
                <div class="col-md-1 d-flex align-self-center pt-3">
                    <button type="button" class="btn red-icon btn-sm btn-ukloni-termin">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `);

        $('#termini-container').append($row);

        var fpOd = flatpickr($row.find('input[name$="[datum_od]"]')[0], fpOptions);
        var fpDo = flatpickr($row.find('input[name$="[datum_do]"]')[0], fpOptions);

        if (datum_od) fpOd.setDate(datum_od, false);
        if (datum_do) fpDo.setDate(datum_do, false);
    }

    $(function () {
        var fieldErrors = @json($errors->messages());
        // old() ima prioritet nad $termini (slučaj neuspele validacije)
        var termini = @json(old('termini') ?: $termini);
        var terminiKeys = Object.keys(termini);

        if (terminiKeys.length > 0) {
            terminiKeys.forEach(function (origKey) {
                var t = termini[origKey];
                dodajTermin(t.datum_od, t.datum_do, t.broj_dostupnih_mesta);

                var $row = $('#termini-container .termin-row').last();
                ['datum_od', 'datum_do', 'broj_dostupnih_mesta'].forEach(function (field) {
                    var errKey = 'termini.' + origKey + '.' + field;
                    if (fieldErrors[errKey]) {
                        $row.find('input[name$="[' + field + ']"]')
                            .addClass('is-invalid')
                            .closest('.form-field')
                            .append('<div class="invalid-feedback d-block">' + fieldErrors[errKey][0] + '</div>');
                    }
                });
            });
        } else {
            dodajTermin();
        }

        $('#btn-dodaj-termin').on('click', function () {
            dodajTermin();
        });

        $(document).on('click', '.btn-ukloni-termin', function () {
            if ($('.termin-row').length > 1) {
                $(this).closest('.termin-row').remove();
            }
        });

        // Hotel po državi
        $('#id_drzave').on('change', function () {
            var idDrzave = $(this).val();
            var $hotelSelect = $('#id_hotela');
            var trenutniHotel = $hotelSelect.val();

            $hotelSelect.empty().append('<option></option>');

            if (!idDrzave) return;

            $.get('{{ route('hoteli.poDrzavi', '') }}/' + idDrzave, function (data) {
                $.each(data, function (i, hotel) {
                    $hotelSelect.append(new Option(hotel.text, hotel.id, false, hotel.id == trenutniHotel));
                });
                $hotelSelect.trigger('change');
            });
        });

        $('#id_drzave').trigger('change');
    });
</script>
@endsection