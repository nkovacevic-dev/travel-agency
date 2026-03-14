<div class="form-field">
    <label for="{{$name}}" class="label-select">{{$label}} @if($required) * @endif</label>
    <textarea name="{{$name}}" id="{{$name}}" class="form-control @error($name) is-invalid @enderror" placeholder=""
        @if($readonly) readonly @endif @if($disabled) disabled @endif>{!!old($name, $value)!!}</textarea>
        
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror

</div>