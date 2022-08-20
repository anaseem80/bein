$(document).ready(function () {
    $(document).on('click', '.add_to_cart', function () {
        var id = $(this).data('id');
        var qty = 1;
        if ($(this).siblings('input[type="number"]').length > 0) {
            qty = $(this).siblings('input[type="number"]').val();
        }
        var data = {
            '_token': csrf_token,
            'id': id,
            'qty': qty
        };
        $.post(add_to_cart, data, function (response) {
            $.dialog({
                title: '',
                content: `<div class="mt-3">${response.message}</div>`,
                type: response.success ? 'blue' : 'red',
                backgroundDismiss: true
            })
            getCartCounter();
        })
    })

    $(document).on('click', '#cart-btn', function () {
        var content = `
        <div class="p-3">
            <h5 class="mt-2"><a class="text-decoration-none" href="shoppingCart" title="الذهاب إلى سلة المشتريات">سلة المشتريات</a></h5>
            <table class="table table-hover" id="cart-pop">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>المجموع</th>
                    </tr>
                </thead>
            </table>
        </div>
        `;

        $.dialog({
            title: false,
            content: content,
            backgroundDismiss: true,
            columnClass: 'col-md-8 col-md-offset-2',
            onContentReady: function () {
                initCartTable('#cart-pop');
            }
        })

    })
    getCartCounter();
})

function getCartCounter() {
    $.get(cart_counter, function (response) {
        if (response.counter > 0) {
            $('#cart-counter').text(response.counter).removeClass('hidden');
        } else {
            $('#cart-counter').addClass('hidden');
        }
    })
}
