@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Lista hotela</h4>
        <a href="{{ route('hoteli.create') }}" class="btn button-primary">
            <i class="fa fa-plus"></i> Dodaj
        </a>
    </div>
    <div class="card-body">
        <table class="table" id="datatable_hoteli" style="width: 100%" data-url="{{ route('hoteli.datatable')}}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Država</th>
                    <th>Grad</th>
                    <th>Broj zvezdica</th>
                    <th>Akcije</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('content_scripts')
<script src="{{asset('js/app/hotel/datatable.js') }}"></script>
@endsection