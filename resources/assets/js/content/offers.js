$(document).ready(function() {
    var offers = $('#offers').DataTable({
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
            url: dashboard_site + "/offers",
            type: "GET",
        },

        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex"
            },
            {
                data: "package.name",
                name: "package.name"
            },
            {
                data: "price",
                name: "price",
                render: function(d, t, r, m) {
                    return d + ' ' + currency
                }
            },
            {
                data: "duration",
                name: "duration",
                render: function(d, t, r, m) {
                    return d + " يوم";
                }
            },
            {
                data: "from",
                name: "from"
            },
            {
                data: "to",
                name: "to"
            },
            {
                data: "status",
                name: "status",
                render: function(d, t, r, m) {
                    switch (d) {
                        case 0:
                            return "<span class='text-warning'>لم يبدأ</span>";
                        case 1:
                            return "<span class='text-success'>ساري</span>";
                        case 2:
                            return "<span class='text-danger'>انتهى</span>";
                    }
                }
            },
            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <a href="${dashboard_site}/offers/${r.id}/edit" class="btn btn-primary" class="btn btn-primary edit" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></a>
                       
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
        var price = $(this).data('price');
        var duration = $(this).data('duration');
        var from = $(this).data('from');
        var to = $(this).data('to');
        $.confirm({
            title: 'تعديل العرض',
            content: `
                <div class="form-group">
                    <label>السعر</label>
                    <input class="form-control numeric" id="editPrice" value="${price}" />
                </div>
                <div class="form-group">
                    <label>المدة</label>
                    <input class="form-control numeric" id="editDuration" value="${duration}" />
                </div>
                <div class="form-group">
                    <label>يبدأ في</label>
                    <input class="form-control" id="editFrom" type="date" value="${from}" />
                </div>
                <div class="form-group">
                    <label>ينتهي في</label>
                    <input class="form-control" id="editTo" type="date" value="${to}" />
                </div>
            `,
            buttons: {
                تعديل: {
                    btnClass: 'btn-primary',
                    action: function() {
                        var data = {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'id': id,
                            'price': $('#editPrice').val(),
                            'duration': $('#editDuration').val(),
                            'from': $('#editFrom').val(),
                            'to': $('#editTo').val(),
                        };
                        $.post(update_offer, data, function(response) {
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
                                offers.ajax.reload();
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
    $(document).on('click', '#addNewOffer', function() {
        var package_id = $('#package_id').val();
        var price = $('#newPrice').val();
        var duration = $('#newDuration').val();
        var from = $('#newFrom').val();
        var to = $('#newTo').val();
        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'package_id': package_id,
            'price': price,
            'duration': duration,
            'from': from,
            'to': to,
        };
        $.post(add_new_offer, data, function(response) {
            if (response.success) {
                $('#package_id').val("");
                $('#newPrice').val("");
                $('#newDuration').val("");
                $('#newFrom').val("");
                $('#newTo').val("");
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
                offers.ajax.reload();
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

    })
})