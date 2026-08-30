<div class="form-group">
    <span class="span-input">{{ $label }} @if($required) * @endif</span>

    @if($multiple && !empty($existing))
    <div class="d-flex flex-wrap gap-2 mb-2">
        @foreach($existing as $path)
        <img src="{{ asset('storage/' . $path) }}" class="img-thumbnail" style="width:80px;height:80px;object-fit:cover;">
        @endforeach
    </div>
    @endif

    <input type="file"
        class="form-control @error($name) is-invalid @enderror @error($name.'.*') is-invalid @enderror"
        id="{{ $name }}"
        name="{{ $multiple ? $name.'[]' : $name }}"
        accept="{{ $type }}"
        @if($multiple) multiple @endif
        @if($disabled) disabled @endif
        @if($required) required @endif>

    @if($multiple)
    <div id="{{ $name }}-preview" class="d-flex flex-wrap gap-2 mt-2"></div>
    <small class="text-muted">{{ __('Maksimalno 5 slika (jpg, png, webp)') }}</small>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @error($name.'.*')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@if($multiple)
<script>
(function () {
    var input = document.getElementById('{{ $name }}');
    var preview = document.getElementById('{{ $name }}-preview');
    input.addEventListener('change', function () {
        preview.innerHTML = '';
        var files = Array.from(this.files);
        if (files.length > 5) {
            alert('{{ __('Možete izabrati maksimalno 5 slika.') }}');
            this.value = '';
            return;
        }
        files.forEach(function (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.cssText = 'width:80px;height:80px;object-fit:cover;';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
}());
</script>
@endif