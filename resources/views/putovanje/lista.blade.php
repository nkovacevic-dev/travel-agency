@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h4>Lista putovanja</h4>
        <a href="{{ route('putovanja.create') }}" class="btn button-primary">
         Dodaj
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table id="datatable_putovanja" class="table" style="width: 100%" data-url="{{ route('putovanja.datatable')}}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Država</th>
                    <th>Grad</th>
                    <th>Cena (EUR)</th>
                    <th>Datum početka</th>
                    <th>Datum zavrsetka</th>
                    <th>Rezervacije</th>
                    <th>Akcije</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('content_scripts')
<script src="{{asset('js/app/putovanje/datatable.js')}}"></script>
@endsection