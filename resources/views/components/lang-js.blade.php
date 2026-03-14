<script>
    var Lang = {
        lang_data: @json(json_decode(
            file_get_contents(base_path('resources/lang/'.App::currentLocale().'.json')))),
        get: function(str, params = {}){
            if(this.lang_data.hasOwnProperty(str)){
                let translation = this.lang_data[str];
                for (const p in params){
                    translation = translation.replace(`:${p}`,params[p])
                }
                return translation;
            }
            return str;
        },
        getLocale: function(){
            return @json(App::currentLocale())
        }
    }
    
    console.log(@json(App::currentLocale()))
</script>