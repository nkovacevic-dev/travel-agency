
<div class="form-field">
    <label for="{{$name}}" class="label-select">{{$label}} @if($required) * @endif</label>     
    <input type="number" class="form-control @error($name) is-invalid @enderror" id="{{$name}}"
        inputmode="numeric" pattern="[0-9]*"
        name="{{$name}}" placeholder=" " value="{{old($name, $value)}}"
        @if($disabled) disabled @endif @if($step) step="{{$step}}" @else step="any" @endif @if($readonly) readonly @endif />
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>