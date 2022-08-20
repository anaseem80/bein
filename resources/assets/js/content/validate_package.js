$(document).ready(function() {

    // $('#form').validate({
    //     rules: {
    //         name: "required",
    //         description: "required"
    //     },
    //     messages: {
    //         name: "برجاء إدخال اسم الباقة",
    //         description: "برجاء إدخال وصف الباقة"
    //     }



    // })
    // $('.form1').each(function(e) {

    $("#form").validate({
            rules: {
                name: "required",
                parent_id: "required",
                description: "required",
                price_90: "required",
                price_180: "required",
                price_365: "required",
                duration: "required",
                "devices[]": {
                    required: function() {
                        return $('input[type="radio"][name="type"]:checked').val() == "new" || $('input[type="radio"][name="type"]:checked').val() == "both";
                    }
                },
                // device_id: {
                //     required: function () {
                //         return $('input[type="radio"][name="type"]:checked').val() == "new" || $('input[type="radio"][name="type"]:checked').val() == "both";
                //     }
                // },
                // price_device: {
                //     required: function () {
                //         return $('input[type="radio"][name="type"]:checked').val() == "new" || $('input[type="radio"][name="type"]:checked').val() == "both";
                //     }
                // },
                "channels[]": "required",
            },
            messages: {
                name: "برجاء إدخال اسم الباقة",
                parent_id: "برجاء اختيار باقة رئيسية",
                description: "برجاء إدخال وصف الباقة",
                price_90: "برجاء إدخال سعر الباقة",
                price_180: "برجاء إدخال سعر الباقة",
                price_365: "برجاء إدخال سعر الباقة",
                price_device: $('input[type="radio"][name="type"]:checked').val() == "new" ? "برجاء إدخال سعر الجهاز لللإشتراك الجديد" : "برجاء إدخال سعر الجهاز ليظهر في صفحة الإشتراك الجديد",
                duration: "برجاء إدخال مدة الباقة",
                "devices[]": $('input[type="radio"][name="type"]:checked').val() == "new" ? "برجاء إختيار الجهاز لللإشتراك الجديد" : "برجاء إختيار الجهاز ليظهر في صفحة الإشتراك الجديد",
                // device_id: $('input[type="radio"][name="type"]:checked').val() == "new"? "برجاء إختيار الجهاز لللإشتراك الجديد":"برجاء إختيار الجهاز ليظهر في صفحة الإشتراك الجديد",
                "channels[]": "برجاء اختيار قنوات",
            }



        })
        // })
})