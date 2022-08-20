$(document).ready(function() {

    $('#form').validate({
        rules: {
            name: "required",
            price: "required",
            description: "required"
        },
        messages: {
            name: "برجاء إدخال موديل الجهاز",
            price: "برجاء إدخال سعر الجهاز",
            description: "برجاء إدخال وصف الجهاز"
        }



    })
})