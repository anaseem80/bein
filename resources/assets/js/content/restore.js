$(document).ready(function() {
    $(document).on('click', '.restore', function() {
        var id = $(this).data('id');
        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': id
        };
        $.confirm({
            title: 'تأكيد استعادة العنصر',
            backgroundDismiss: true,
            content: 'هل أنت متأكد من الرجوع عن حذف هذا العنصر؟',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                نعم: {
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post(restore_item, data, function(response) {
                            if (response.success) {
                                $.alert({
                                    title: '',
                                    content: 'تم الرجوع عن حذف العنصر ',
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
                                $('table').DataTable().ajax.reload();
                            }
                            checkDeletedComments();
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