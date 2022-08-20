$(document).ready(function() {

    $('#form').validate({
        rules: {
            name: "required",
            amount: "required",
            description: "required",
        },
        messages: {
            name: "برجاء إدخال اسم القنوات",
            amount: "برجاء اختيار المدة",
            description: "برجاء إدخال وصف القنوات"
        }



    })
})