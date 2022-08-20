$(document).ready(function () {
    var users = $('#users').DataTable({
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
            url: dashboard_site + "/user/list",
            type: "GET",
            data: {
                'role': function () {
                    return $('input[name="role"]:checked').val()
                }
            }
        },

        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "avatar",
                name: "avatar",
                render: function (d, t, r, m) {
                    if (d == null) {
                        return null;
                    } else {
                        return `
                        <img src="${home_site}/${d}" width="70" height="70" style="border-radius:50%">
                        `;
                    }
                }
            },
            {
                data: "email",
                name: "email"
            },
            {
                data: "mobile",
                name: "mobile"
            },
            {
                data: "role",
                name: "role",
                render: function (d, t, r, m) {
                    if (d) {
                        switch (d) {
                            case 'admin':
                                return 'مسؤول';
                            case 'owner':
                                return 'المالك';
                        }
                    } else {
                        return 'مستخدم';
                    }
                }
            },
            {
                data: "bein_cards",
                name: "bein_cards",
                render: function (d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    if (d.length > 0) {
                        return `<button type="button" class="btn btn-warning showBeinCards" data-cards='${JSON.stringify(d)}'><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="عرض"></i></button>`
                    } else {
                        return "لا يوجد"
                    }
                }
            },
            {
                data: "action",
                name: "action",
                render: function (d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <button type="button" data-id="${r.id}" data-role="${r.role}" class="btn btn-primary role" data-toggle="tooltip" data-placement="top" title="تعديل الصلاحية"><i class="fa fa-edit"></i></button>
                       
                        <button type="button" data-id="${r.id}" class="btn btn-danger remove" data-toggle="tooltip" data-placement="top" title="حذف"><i class="fa fa-trash"></i></button>
                    `;
                }
            },


        ],
        columnDefs: [{
                targets: [0, 1, 2, 3],
                searchable: true
            },

        ],
        ordering: false,
    })

    $(document).on('change', 'input[name="role"]', function () {
        users.ajax.reload();
    })
    $(document).on('click', '.role', function () {
        var id = $(this).data('id');
        var role = $(this).data('role');

        $.confirm({
            title: 'تعديل صلاحية المستخدم',
            backgroundDismiss: true,
            type: 'blue',
            typeAnimated: true,
            content: `
            <div class="form-group">
            <label>الصلاحية</label>
            <select class="form-control" id="role-selection">
            <option value="" ${role==''||role==null?'selected':''}>مستخدم</option>
            <option value="admin" ${role=='admin'?'selected':''}>مسؤول</option>
            </select>
            </div>
            `,
            buttons: {
                تأكيد: {
                    btnClass: 'btn-blue',
                    action: function () {
                        var newRole = $('#role-selection').val();
                        var data = {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'id': id,
                            'role': newRole
                        };
                        $.post(change_role, data, function (response) {
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
                                            action: function () {}
                                        }
                                    }
                                });
                                users.ajax.reload();
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
                                            action: function () {}
                                        }
                                    }
                                });
                            }
                        })
                    }
                },
                إلغاء: {
                    btnClass: 'btn-red',
                    action: function () {

                    }
                }
            }
        })
    });


    $(document).on('click', '.showBeinCards', function () {
        var cards = $(this).data('cards');
        var content = $(`<table class="table">
        <thead>
            <tr>
                <th>Bein Cards Numbers</th>
            </tr>
        </thead>
        <tbody></tbody>
        </table>`);
        for (var card of cards) {
            var tr = `<tr></tr>`;
            $(content).find('tbody').append($(tr).append(`<td>${card.bein_card_number}</td>`));
        }

        $.dialog({
            title: false,
            content: content,
            backgroundDismiss: true,
        })
    });



})
