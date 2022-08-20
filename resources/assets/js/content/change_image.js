$(document).ready(function() {
    $('.image_preview_container').click(function() {
        $(this).parents('div.image-container').find('input.image').trigger('click');
    });
    $('input.image').change(function() {

        let reader = new FileReader();

        reader.onload = (e) => {

            $(this).parents('div.image-container').find('.image_preview_container').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

    });

    //remove image function in insert and update by ajax
    $('.remove-image-button').click(function() {
        var btn = $(this);
        var image = $(this).parents('div.remove-image').siblings('img.image_preview_container')
        var id = image.data('id');
        var type = image.data('type');
        $.confirm({
            title: "حذف الصورة",
            backgroundDismiss: true,
            type: 'red',
            typeAnimated: true,
            content: "هل أنت متأكد من حذف الصورة؟",
            buttons: {
                نعم: {
                    btnClass: 'btn-blue',
                    action: function() {
                        if (type == 1) {
                            var data = {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                'id': id
                            };

                            $.post(delete_image, data, function(response) {
                                if (response.success) {
                                    $.alert({
                                        title: '',
                                        content: 'تم حذف الصورة!',
                                        type: 'blue',
                                        backgroundDismiss: true,
                                        buttons: {
                                            cancel: {
                                                text: 'حسنًا',
                                                btnClass: 'btn-blue',
                                                action: function() {}
                                            }
                                        }
                                    });
                                    image.attr('src', img);
                                }
                            });
                        } else {
                            btn.parents('div.image-container').find('input.image').val(null);
                            image.attr('src', img);
                        }
                    }
                },
                لا: {
                    btnClass: 'btn-red',
                    action: function() {
                        // $.alert('Canceled!');
                    },
                }

            }
        });

    });

})