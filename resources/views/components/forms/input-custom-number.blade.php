<div class="form-floating">
<input id="{{$name}}" name="{{$name}}" type="text"
        class="form-control @error($name) is-invalid @enderror" value="{{old($name, $value)}}"
        placeholder="" @if($disabled) disabled @endif @if($readonly) readonly @endif />
    <label for="{{$name}}" id="{{$name}}_label" >{{$label}} @if($required) * @endif</label>
    @error($name)
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>

 
<script>
    $(()=>{
        $('#{{$name}}').on("focus", function( e ) {
            // console.log('focus')
            if($(this).val()=='0,00'){
                $(this).val('')
            }
        })
        $('#{{$name}}').on("blur", function( e ) {
            // console.log('blur')
            if( $(this).val()!=''){
                var formatted_value = currency($(this).val(),{
                    pattern: '#',
                    separator: '.', 
                    decimal: ',', 
                }).format();
                $(this).val( formatted_value );
            }
            
        })
        $('#{{$name}}').on('keydown', function(e){
            // console.log('keydown')
            var strAllowedKeys = ",.0123456789";
            if((e.originalEvent.key==',' || e.originalEvent.key=='.') && $(this).val().includes(',')){
                return false;
            }
            
            var strDisallowedKeys = '!"#$%&\'()*+-/:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';

            if( $.inArray( e.originalEvent.key, strDisallowedKeys.split('')) !== -1){
                return false
            }
            return;
        })
        $('#{{$name}}').on("keyup", function( e ) {
            if((e.originalEvent.key=='Backspace' || e.originalEvent.key=="Tab") && $(this).val()==""){
                return false;
            }
            if(e.originalEvent.key=="."){
                $(this).val($(this).val().substr(0,$(this).val().length-1) + ',');
            }
            var dots_before = ($(this).val().match(/\./g) || []).length
            var decimal_separator = $(this).val().indexOf(',') !== -1;
            var decimals = 0;
            if(decimal_separator){
                decimals = ($(this).val().length - 1) - $(this).val().indexOf(',')
            }

            var position = this.selectionStart;
            var formatted_value = currency($(this).val(),{
                pattern: '#',
                separator: '.', 
                decimal: ',', 
            }).format();
            if( decimal_separator){
                if(decimals!=2){
                    console.log('Skracivanje')
                    // console.log(formatted_value.substr(0,formatted_value.length-2))
                    formatted_value = formatted_value.substr(0,formatted_value.length- (2-decimals))
                }
            }else{
                formatted_value = formatted_value.substr(0,formatted_value.length - 3)
            }
            $(this).val( formatted_value );
            var dots_after = ($(this).val().match(/\./g) || []).length

            position += dots_after - dots_before;
            this.selectionStart = position;
            this.selectionEnd = position;
        });
        
        $('form:has(#{{$name}})').on('submit', function(){
            $('#{{$name}}').val($('#{{$name}}').val().replace(/\./g,'').replace(',','.'))
            // alert($('#{{$name}}').val());

        });

        var initial_value = $('#{{$name}}').val();
        if( initial_value == ''){
            initial_value = '0';
        }

        if( initial_value.charAt(initial_value.length-3)=='.'){
            initial_value = initial_value.replace('.',',')
        }
        // if( initial_value.charAt(initial_value.length-3)==','){
        //     initial_value = initial_value.replace('.',',')
        // }
        if( initial_value != '0' ){
            $('#{{$name}}').val( currency(initial_value,{
                pattern: '#',
                separator: '.', 
                decimal: ',', 
            }).format());
        }
    });
</script>