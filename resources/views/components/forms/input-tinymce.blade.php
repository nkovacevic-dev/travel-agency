<div class="form-group">
    <textarea name="{{$name}}" id="{{$name}}" 
    class="form-control tiny @error($name) is-invalid @enderror"
    placeholder="..." @if($storePictureUrl) data-storePictureUrl="{{ $storePictureUrl }}" @endif
    @if($disabled) disabled @endif>{!!old($name, $value)!!}</textarea>
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>
<!-- Initialize TinyMCE -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#{{$name}}',
            license_key: 'gpl',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            menubar: false,
            plugins: 'advlist autolink lists link image charmap print preview anchor textcolor',
            toolbar_mode: 'floating'
        });
    });
</script>