@push('tab_links_'.$tabs_id)

<li class="nav-item" role="presentation">
    <a class="nav-link @if($active) active @endif" id="nav-{{$name}}-tab" data-bs-toggle="tab" href="#nav-{{$name}}"
        role="tab" aria-controls="nav-{{$name}}" aria-selected="{{ $active ? 'true' : 'false' }}">{{$label}}</a>
</li>
@endpush
@push('tab_links_responsive_'.$tabs_id)
    <a class="nav-link @if($active) active @endif" id="nav-{{$name}}-tab" data-bs-toggle="tab" href="#nav-{{$name}}"
        role="tab" aria-controls="nav-{{$name}}" aria-selected="{{ $active ? 'true' : 'false' }}">{{$label}}</a>
@endpush

@push('tab_content_'.$tabs_id)
<div class="tab-pane fade show @if($active) active @endif" id="nav-{{$name}}" role="tabpanel" aria-labelledby="nav-{{$name}}-tab">
    {{$slot}}
</div>

@endpush