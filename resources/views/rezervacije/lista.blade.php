@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Lista rezervacija</h4>
        <a href="{{ route('rezervacije.create') }}" class="btn button-primary">
            <i class="fa fa-plus"></i> Dodaj
        </a>
    </div>
    <div class="card-body">
        <table id="datatable_rezervacije" class="table" style="width: 100%" data-url="{{ route('rezervacije.datatable') }}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Putovanje</th>
                    <th>Ime i prezime</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Termin</th>
                    <th>Odrasli</th>
                    <th>Deca</th>
                    <th>Ukupna cena</th>
                    <th>Status</th>
                    <th>Datum kreiranja</th>
                    <th>Akcije</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('content_scripts')
<script src="{{ asset('js/app/rezervacije/datatable.js') }}"></script>
@endsection
