$(document).ready(function() {

    $('#form').validate({
        rules: {
            name: "required",
        },
        messages: {
            name: "برجاء إدخال اسم الفئة",
        }



    })
})