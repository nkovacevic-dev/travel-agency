<div>
    <label>{{$label}}:</label>
    <br>
    <div id="{{$name}}_canvas" class="form-control @error($name) is-invalid @enderror" style="width:100%"></div>
   <br>
    <a id="clear_{{$name}}" class="tertiary">{{__('lang.potpis_obrisi')}}</a>
    <textarea id="{{$name}}" name="{{$name}}" style="display: none"></textarea>
    <textarea id="{{$name}}_empty" name="{{$name}}_empty" style="display: none"></textarea>
    @error($name)
        <div class="invalid-feedback">{!!$message!!}</div>
    @enderror
</div>
<script>
    $(()=>{
        var {{$name}} = $('#{{$name}}_canvas').signature({
            syncField: '#{{$name}}', 
            syncFormat: 'PNG',
            background: 'transparent',
            guideline: true,
            // color: 'red'
            // change: function(event, ui){ console.log('changed') }
        });
        $('#clear_{{$name}}').click(function (e) {
            console.log('brisanje potpisa')
            e.preventDefault();
            {{$name}}.signature('clear');
            $("#{{$name}}64").val('');
        });
    })


// add a listener to 'scroll' event
document.addEventListener("scroll", function() {
    // get the active element and call blur
    document.activeElement.blur();
});
</script>