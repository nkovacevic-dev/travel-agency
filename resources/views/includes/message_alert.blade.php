<div class="row justify-content-center">
    <div class="col-md-6">
        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show text-center">
            {{ \Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif (\Session::has('fail'))
        <div class="alert alert-danger alert-dismissible fade show text-center">
            {{ \Session::get('fail') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".alert-dismissible").delay(10000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>