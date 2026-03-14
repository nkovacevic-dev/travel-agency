<div class="form-field">
    <label id="{{$name}}_label" class="label-select">{!! ($label) !!} @if($required) * @endif</label>
    <div id="flatpickr_{{$name}}" class="flatpickr flatpickr_{{$name}}">
        <input id="{{$name}}" name="{{$name}}" type="text" value="{{old($name, ($value ? \Carbon\Carbon::parse($value)->format('d.m.Y.') : null) )}}"  data-input class="form-control @error($name) is-invalid @enderror" @if($disabled) disabled @endif> 
        <!-- input is mandatory -->
        @error($name)
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
    </div>
</div>
@if(!$disabled)
<script>
    flatpickr("#flatpickr_{{$name}}", {
        dateFormat: "d.m.Y.",
        wrap: true,
        allowInput: true, // prevent "readonly" prop
        onReady: function(selectedDates, dateStr, instance) {
            let el = instance.element;
            function preventInput(event) {
                event.preventDefault();
                return false;
            };
            el.onkeypress = el.onkeydown = el.onkeyup = preventInput; // disable key events
            el.onpaste = preventInput; // disable pasting using mouse context menu

            el.style.caretColor = 'transparent'; // hide blinking cursor
            el.style.cursor = 'pointer'; // override cursor hover type text
            el.style.color = '#585858'; // prevent text color change on focus
            el.style.backgroundColor = '#f7f7f7'; // prevent bg color change on focus
        },
    });
</script>
@endif