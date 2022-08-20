$(document).ready(function() {
    $(document).on('click', '#add-category', function() {
        $.confirm({
            title: 'إضافة فئة جديدة',
            backgroundDismiss: true,
            type: 'green',
            typeAnimated: true,
            content: `
            <div class="form-group">
            <label>الاسم</label><span class="text-danger"> *</span>
            <input class="form-control" type="text" id="newCategory-name">
            </div>
            `,
            buttons: {
                حفظ: {
                    btnClass: 'btn-blue save-category',
                    isDisabled: true,
                    action: function() {
                        var name = $('#newCategory-name').val();
                        if (name != '' && name != null) {
                            var data = {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                'name': name,
                                'type': 'json'
                            };
                            $.post(store_category, data, function(response) {
                                if (response.success) {
                                    $.alert({
                                        title: '',
                                        content: 'تم إضافة الفئة بنجاح',
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
                                    var category = response.category;
                                    var newOption = new Option(category.name, category.id, true, true);
                                    $('#categories').append(newOption).trigger('change');
                                }
                            })
                        }
                    }
                },
                إلغاء: {
                    btnClass: 'btn-red',
                }
            }
        })
    })
    $(document).on('keyup', '#newCategory-name', function() {
        if ($(this).val() != '' && $(this).val() != null) {
            $('button.save-category').removeAttr('disabled');
        } else {
            $('button.save-category').attr('disabled', 'disabled');
        }

    })
})