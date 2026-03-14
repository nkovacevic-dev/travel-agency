<div class="btn-group" role="group">
    <a href="{{ route('rezervacije.show', $id) }}" class="btn btn-sm btn-info" title="Prikaži">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('rezervacije.edit', $id) }}" class="btn btn-sm btn-warning" title="Izmeni">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $id }}" title="Obriši">
        <i class="fa fa-trash"></i>
    </button>
</div>
