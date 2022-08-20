$(document).ready(function() {
    var categories = $('#categories').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        buttons: [{
            text: 'إضافة جديد',
            className: 'btn btn-primary pull-left',
            action: function(e, dt, node, config) {
                document.location.href = dashboard_site + '/category/create';
            }
        }],
        "pageLength": 25,
        "bInfo": true,
        "bLengthChange": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/category",
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
                data: "blogs.length",
                name: "blogs",
            },

            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <a href="${dashboard_site}/category/${r.id}/edit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></a>
                       
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
})