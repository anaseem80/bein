<script src="{{ asset('resources/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('resources/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/sb-admin-2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('resources/assets/js/content/logout.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/numeric.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/success.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })

    function checkDeletedComments() {
        $.get('{{route("checkDeletedComments")}}',function(response){
            if(response){
                $('#deletedComments').addClass('text-danger');
            }else{
                $('#deletedComments').removeClass('text-danger');
            }
        })
    }
</script>
<script src="{{ asset('resources/assets/js/content/sidebar.js') }}"></script>
