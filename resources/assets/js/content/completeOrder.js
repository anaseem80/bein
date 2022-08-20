$(document).ready(function() {
    $('#form').validate({
        rules: {
            first_name: 'required',
            last_name: 'required',
            bein_card_number: 'required',
            country: 'required',
            address: 'required',
            mobile: {
                'required': function() {
                    return $('#email').val() == ''
                }
            },
            mobile_key: {
                'required': function() {
                    return $('#phonenubmer').val() == ''
                }
            },
            email: {
                'required': function() {
                    return $('#phonenubmer').val() == ''
                }
            },
        },
        messages: {
            first_name: 'برجاء إدخال الاسم الأول',
            last_name: 'برجاء إدخال الاسم الأخير',
            country: 'برجاء إختيار الدولة',
            bein_card_number: 'برجاء إدخال رقم الكارت',
            address: 'برجاء إدخال عنوان الشارع/الحي',
            mobile: 'برجاء إدخال رقم الهاتف',
            mobile_key: 'برجاء إدخال مفتاح الدولة ',
            email: 'برجاء إدخال البريد الالكتروني',
        }
    })

    changeCountry();
    $(document).on('change', '#country_id', changeCountry)

    function changeCountry() {
        var country_id = $('#country_id').val();
        var shipping = theDevice?.countries?.find(c => c.id == country_id)?.pivot.shipping_price * 1;
        shipping = shipping ? shipping : 0;
        var country = countries.find(c => c.id == country_id);

        if (country.key == 0) {
            $('#phonekey').removeAttr('readonly').val('');
        } else {
            $('#phonekey').attr('readonly', true).val(country.key);
        }
        $('#shipping').text(shipping);
        $('input[name="shipping"]').val(shipping);
        var taxes=0;
        var total = $('input[name="total"]').data('total') * 1;
        
        $('.taxes').each(function(){
            var type=$(this).data('type');
            var value=$(this).data('value')*1;
            if(type=='percent'){
                if (type == "new") {
                    taxes+=(value/100)*(total+shipping);
                }else{
                    taxes+=(value/100)*total;
                }
            }else{
                taxes+=value;
            }
        })
        taxes=Math.round(taxes);
        $('input[name="taxes"]').val(taxes);
        $('input[name="total"]').val(total + taxes);
        if (type == "new") {
            $('input[name="total"]').val(Math.round(total + shipping+taxes));
            $('#total').text(Math.round(total + shipping+taxes));
        }
    }
    changeDuration();
    $(document).on('change', '#choose_duration', changeDuration)

    function changeDuration() {
        var duration = $('#choose_duration').val();
        var price = product['price_' + duration] * 1;
        var shipping=$('#shipping').text()*1;
        var taxes=0;
        var device_price=$('input[name="device_price"]').val()*1??0;

        var pageType=type;
        $('.taxes').each(function(){
            var type=$(this).data('type');
            var value=$(this).data('value')*1;
            if(type=='percent'){
                if (pageType == "new") {
                    taxes+=(value/100)*(price+shipping+device_price); 
                }else{
                    taxes+=(value/100)*price;
                }
            }else{
                taxes+=value;
            }
        })
        taxes=Math.round(taxes);

        $('input[name="duration"]').val(duration);
        $('input[name="sub_total"]').val(price);
        $('input[name="taxes"]').val(taxes);
        $('#price-duration').text(price)
        if (type == "renew") {
            $('input[name="total"]').attr('data-total', Math.round(price+taxes)).val(Math.round(price+taxes));
            $('#total').text(Math.round(price+taxes));
        } else {
            $('input[name="total"]').attr('data-total', Math.round(price + (product.price_device * 1)+taxes)).val(price + (product.price_device * 1)+shipping+taxes);
            $('#total').text(Math.round(price + (product.price_device * 1)+shipping+taxes));
        }
    }
})