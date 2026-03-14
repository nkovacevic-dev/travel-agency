<div class="form-group">
    <span for="naziv" class="span-input">{{$label}} @if($required) * @endif</span>
    <input type="file" class="form-control @error($name) is-invalid @enderror" id="{{$name}}"
        name="{{$name}}" placeholder="{{$label}}" accept="{{$type}}" @if($disabled) disabled @endif>
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>