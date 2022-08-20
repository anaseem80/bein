$(document).ready(function() {

    $('#form').validate({
        rules: {
            name: "required",
            content: "required",
        },
        messages: {
            name: "برجاء إدخال عنوان المقال",
            content: "برجاء إدخال محتوى المقال",
        }



    })
})