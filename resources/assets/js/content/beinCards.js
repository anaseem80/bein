$(document).ready(function() {
    var beinCards = $('#beinCards').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        "pageLength": 25,
        "bInfo": true,
        "bLengthChange": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/beinCard",
            type: "GET",
        },

        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex"
            },
            {
                data: "bein_card_number",
                name: "bein_card_number"
            },

            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <button type="button" data-id="${r.id}" data-number="${r.bein_card_number}" class="btn btn-primary edit" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></button>
                       
                        <button type="button" data-id="${r.id}" class="btn btn-danger remove" data-toggle="tooltip" data-placement="top" title="حذف"><i class="fa fa-trash"></i></button>
                    `;
                }
            },


        ],
        columnDefs: [{
                targets: [0, 1],
                searchable: true
            },

        ],
        ordering: false,
    })
    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        var number = $(this).data('number');
        $.confirm({
            title: 'تعديل الرقم',
            content: `
                <div class="form-group">
                    <input class="form-control numeric" id="editCard" value="${number}" />
                </div>
            `,
            buttons: {
                تعديل: {
                    btnClass: 'btn-primary',
                    action: function() {
                        var data = {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'id': id,
                            'number': $('#editCard').val()
                        };
                        $.post(update_card, data, function(response) {
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
                                beinCards.ajax.reload();
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
                        })
                    }
                },
                إلغاء: {
                    btnClass: 'btn-danger',
                    action: function() {}
                }
            }
        })
    })
    $(document).on('click', '#addNewCard', function() {
        var number = $('#newCard').val();
        if (number) {
            var data = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'number': number
            };
            $.post(add_new_card, data, function(response) {
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
                    beinCards.ajax.reload();
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
            })
        }
    })
})