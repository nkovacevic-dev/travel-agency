<div class="btn-group" role="group">
    <a href="{{ route('putovanja.show', $id) }}" class="btn btn-sm" title="Prikaži">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('putovanja.edit', $id) }}" class="btn btn-sm" title="Izmeni">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm red-icon btn-delete-putovanje" data-id="{{ $id }}" title="Obriši">
        <i class="fa fa-trash"></i>
    </button>
</div>
