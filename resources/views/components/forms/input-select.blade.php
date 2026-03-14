<div class="form-field">
    <label for="{{$name}}" id="{{$name}}_label" class="label-select">{{$label}} @if($required) * @endif</label>
    <select id="{{(!empty($id))?$id:$name}}" class="form-control select2 @error($name) is-invalid @enderror"
        {{-- ako je readonly, ne treba da ima ime, ime će biti dodeljeno skrivenoj kontroli --}}
        @if(!$readonly) @if(!$multiple) name="{{$name}}" @else name="{{$name}}[]" @endif @endif 
        @if($multiple) multiple="multiple" @endif
        @if($disabled || $readonly) disabled @endif >
  
        @if($emptyOption)
        <option selected disabled></option>
        @endif

        @foreach($items as $item)
        @if(!$multiple)
        <option value="{{$item['id']}}" @if($item['id']==old($name, $value)) selected @endif>{{$item['text']}}</option>
        @else
        @php
            $old_value = old($name, $value);
            if(empty($old_value)){
                $old_value = [];
            }
        @endphp
        <option value="{{$item['id']}}" @if(in_array($item['id'], $old_value)) selected @endif>{{$item['text']}}</option>
        @endif
        @endforeach
    </select>
    @if($readonly)
        <input type="hidden" name="{{$name}}" value="{{$value}}">
    @endif
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>
<script>
    $(function(){
        $('#{{(!empty($id))?$id:$name}}').select2({
            @if(!empty($minimumInputLength))
            minimumInputLength: {{ $minimumInputLength }},
            @else
            minimumInputLength: 0,
            @endif
            @if($emptyOption)
            allowClear: true,
            placeholder: ' ',
            @endif
            @if($readonly)
            readonly: true,
            @endif
            @if($tags)
            tags: true,
            @endif
            theme: 'bootstrap4',
            language: select2_lang,
            @if($mesto)
            language: {
                noResults: function() {
                    return `<button style="width: 20%" type="button"
                    class="primary" data-toggle="modal" 
                    data-target="#mestoModal">+</button>
                    </li>`;
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
            @endif
        });
    })
</script>