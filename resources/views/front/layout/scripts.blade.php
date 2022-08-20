{{-- <script src="{{ asset('resources/front/js/libraries/bootstrap.min.js') }}"></script> --}}
<script src="{{ asset('resources/front/js/libraries/a1a75d5546.js') }}"></script>
<script src="{{ asset('resources/front/js/libraries/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="{{ asset('resources/front/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('resources/front/js/libraries/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/logout.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/numeric.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/success.js') }}"></script>
{{-- <script src="{{ asset('resources/assets/js/content/add_to_cart.js') }}"></script> --}}
<script>
    var content_length = 40;
    var delete_item = "{{ route('remove_from_cart') }}";
    var change_cart_count = "{{ route('change_cart_count') }}";
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('resources/assets/js/content/remove.js') }}"></script>
{{-- <script src="{{asset('resources/assets/js/content/cart.js')}}"></script> --}}
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        effect: "fade",
        autoplay: true,
        pagination: {
            el: ".swiper-pagination",
            type: "progressbar",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper = new Swiper(".mySwiper2", {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    function setCartTotalLabels() {
        $.get("{{ route('get_total_labels') }}", function(response) {
            $('#cartSubtotal').text(response.total)
            $('#cartTotal').text(response.total)
        })
    }
</script>
