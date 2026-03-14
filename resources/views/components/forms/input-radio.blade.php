 

@if(!$readonly || ($value==$modelValue))
    <input type="radio"  @if($id) id="{{ $id }}" @endif
        name="{{ $name }}"
        value="{{ $value }}"
        @if (old($name, $modelValue) == $value) checked @endif
        @if($disabled) disabled @endif />
    <span @if($id) for="{{ $id }}" @endif></span>  
    <label @if($id) for="{{ $id }}" @endif>  {{ $label }} @if($required) * @endif</label>
 @endif