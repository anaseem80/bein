$(document).ready(function() {
    changePrice();
    $(document).on('change', '#product_duration', changePrice)
    $(document).on('click', '.completeOrder', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        window.location.href = url + "/" + $('#product_duration').val();
    })

    function changePrice() {
        var duration = $('#product_duration').val();
        $('#product_price').text(product['price_' + duration]);
    }

})