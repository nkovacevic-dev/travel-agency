<div class="form-field">
    <label id="{{$name}}_label" class="label-select">{!! ($label) !!} @if($required) * @endif</label>
    <input type="text" class="form-control @error($name) is-invalid @enderror" id="{{(!empty($id))?$id:$name}}" name="{{$name}}" placeholder="{{$placeholder}} " value="{{old($name, $value)}}" @if($disabled) disabled @endif @if($readonly) readonly @endif />
    @error($name)
    <div class="invalid-feedback">{!!$message!!}</div>
    @enderror
</div>