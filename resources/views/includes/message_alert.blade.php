<div class="alert-box">
    <div class="flex-center position-ref">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="form-group row" id="message" style="margin-bottom:0px !important">
                    <div class="col-md-12">
                        @if (\Session::has('success'))
                        <div class="offset-md-3 col-md-6 alert alert-success alert-dismissible fade show" style="text-align: center;">
                            {{ \Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @elseif (\Session::has('fail'))
                        <div class="offset-md-3 col-md-6 alert alert-danger alert-dismissible fade show" style="text-align: center;">
                            {{ \Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Automatsko zatvaranje nakon 10 sekundi
    $(document).ready(function() {
        $(".alert-dismissible").delay(10000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>