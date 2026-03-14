<div class="form-field">
    <input id="{{$name}}" name="{{$name}}" type="checkbox" data-value="{{$value}}" @if(old($name, $value)) checked @endif @if($disabled) disabled @endif>
    <label class="label-checkbox">{{$label}}</label>
</div>