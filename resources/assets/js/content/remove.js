$(document).ready(function() {
    $(document).on('click', '.remove', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var from = $(this).data('from');
        var permenant = $(this).data('permenant');
        var content = '';
        if (permenant) {
            content = 'هل أنت متأكد من حذف هذا العنصر نهائيًا؟';
        } else {
            content = 'هل أنت متأكد من حذف هذا العنصر؟';
        }
        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': id
        };
        $.confirm({
            title: 'تأكيد الحذف',
            backgroundDismiss: true,
            content: content,
            type: 'red',
            typeAnimated: true,
            buttons: {
                نعم: {
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post(type == 'comment' ? delete_comment : delete_item, data, function(response) {
                            if (response.success) {
                                $.alert({
                                    title: '',
                                    content: response.message,
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
                                if (type == 'package') {
                                    $(`#package-${id}`).remove();
                                } else if (type == 'comment') {
                                    $(`#row-${id}`).remove();
                                    if (from != 'front') {
                                        $('#packages,#blogs').DataTable().ajax.reload();
                                    }
                                } else {
                                    $('table:not(.noDataTable)').DataTable().ajax.reload();
                                }
                            } else {
                                $.alert({
                                    title: '',
                                    content: response.message,
                                    type: 'red',
                                    backgroundDismiss: true,
                                    buttons: {
                                        cancel: {
                                            text: 'حسنًا',
                                            btnClass: 'btn-blue',
                                            action: function() {}
                                        }
                                    }
                                });
                            }
                            if (from != 'front') {
                                checkDeletedComments();
                            }else{
                                setCartTotalLabels();
                                getCartCounter();
                            }

                        })
                    }
                },
                لا: {
                    btnClass: 'btn-red',
                    action: function() {}
                }
            }
        })
    })
})