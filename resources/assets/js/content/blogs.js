$(document).ready(function() {
    var blogs = $('#blogs').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        buttons: [{
            text: 'إضافة جديد',
            className: 'btn btn-primary pull-left',
            action: function(e, dt, node, config) {
                document.location.href = dashboard_site + '/blog/create';
            }
        }],
        "pageLength": 25,
        "bInfo": true,
        "bLengthChange": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/blog",
            type: "GET",
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
                data: "image",
                name: "image",
                render: function(d, t, r, m) {
                    if (d == null) {
                        return null;
                    } else {
                        return `
                        <img src="${home_site}/${d}" width="90" height="90">
                        `;
                    }
                }
            },
            {
                data: "categories",
                name: "categories",
                render: function(d, t, r, m) {
                    var categories = '';
                    for (var i = 0; i < d.length; i++) {
                        var e = '';
                        if (i != 0) {
                            e = ', ';
                        }
                        categories += e + `<a href="${dashboard_site}/category/${d[i]['id']}/edit" target="_blank">${d[i]['name']}</a>`;
                    }
                    return categories;
                }
            },
            {
                data: "is_published",
                name: "is_published",
                render: function(d, t, r, m) {
                    return `
                            <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                <input title="${d==1?'الغاء النشر':'نشر'}" style="cursor:pointer" class="form-check-input change-published" ${d==1?'checked':''} type="checkbox" data-id="${r.id}">
                            </div>
                    `;
                }
            },
            {
                data: "comments",
                name: "comments",
                render: function(d, t, r, m) {
                    if (d.length > 0) {
                        return `<button type="button" class="btn btn-dark comments" data-comments='${JSON.stringify(d)}' data-toggle="tooltip" data-placement="top" title="عرض التعليقات">${d.length}</button>`
                    } else {
                        return 'لا يوجد تعليقات';
                    }
                }
            },
            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <a href="${dashboard_site}/blog/${r.id}/edit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></a>
                        <a href="${dashboard_site}/blog/${r.id}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="معاينة"><i class="fa fa-eye"></i></a>
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
    $(document).on('change', '.change-published', function() {
        var id = $(this).data('id');
        var status = 0;
        $(this).attr('title', 'نشر');
        if ($(this).prop('checked')) {
            status = 1;
            $(this).attr('title', 'إلغاء النشر');
        }
        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': id,
            'status': status
        };
        $.post(change_published, data, function(response) {
            if (response.success) {
                $.alert({
                    title: '',
                    content: response.message,
                    type: 'success',
                    backgroundDismiss: true,
                    buttons: {
                        cancel: {
                            text: 'حسنًا',
                            btnClass: 'btn-blue',
                            action: function() {}
                        }
                    }
                })
            }
        })
    })

})