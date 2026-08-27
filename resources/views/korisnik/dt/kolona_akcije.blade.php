<div class="btn-group" role="group">
    <a href="{{ route('korisnici.show', $id) }}" class="btn btn-sm" title="Prikaži" target="_blank">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('korisnici.edit', $id) }}" class="btn btn-sm" title="Izmeni">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm red-icon btn-delete-korisnik" data-id="{{ $id }}" title="Obriši">
        <i class="fa fa-trash"></i>
    </button>
</div>
