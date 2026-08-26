@extends('layouts.app')

@section('content')
<div class="card">
     <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Lista korisnika</h4>
        <a href="{{ route('korisnici.create') }}" class="btn button-primary">
            <i class="fa fa-plus"></i> Dodaj
        </a>
    </div>
    <div class="card-body">
        <table id="datatable_korisnici" class="table" style="width: 100%" data-url="{{ route('korisnici.datatable')}}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime i prezime</th>
                    <th>Email</th>
                    <th>Akcije</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('content_scripts')
<script src="{{asset('js/app/korisnik/datatable.js')}}"></script>
@endsection