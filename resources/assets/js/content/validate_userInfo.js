$(document).ready(function() {

    $('#form').validate({
        rules: {
            first_name: "required",
            last_name: "required",
            mobile: {
                required: true,
            },

            password: {
                // required: true,
                minlength: 8
            },
            confirm_password: {
                required: function(element) {
                    return $("#password").val() != "";
                },
                minlength: 8,
                equalTo: '#password'
            },
        },
        messages: {
            first_name: "برجاء إدخال الاسم الأول",
            last_name: "برجاء إدخال الاسم الأخير",
            mobile: {
                required: "برجاء إدخال رقم التليفون",
                // minlength: "Mobile number must be 11 numbers",
                // maxlength: "Mobile number must be 11 numbers",
            },

            password: {
                minlength: "كلمة المرور يجب ألا تقل عن 8 أحرف"
            },
            confirm_password: {
                required: "برجاء تأكيد كلمة المرور",
                minlength: "كلمة المرور يجب ألا تقل عن 8 أحرف",
                equalTo: "يجب أن تكون مطابقة لكلمة المرور الجديدة"
            },
        }



    })
})