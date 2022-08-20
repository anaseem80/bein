$(document).ready(function() {
    var comments = $('#comments').DataTable({
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
            url: dashboard_site + "/deleted/comments/" + comment_from,
            type: "GET",
        },

        columns: [{
                data: "item_id",
                name: "item_id"
            },
            {
                data: comment_from + ".name",
                name: comment_from + ".name"
            },
            {
                data: "username",
                name: "username"
            },
            {
                data: "comment",
                name: "comment",
                render: function(d, t, r, m) {
                    if (d != null) {
                        return d.length > 30 ? '<span style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="رؤية المزيد" data-comment="' + d + '" class="longComment">' + d.substr(0, 30) + '...</span>' : d
                    } else {
                        return null;
                    }
                }
            },
            {
                data: "user_deletes.name",
                name: "user_deletes.name"
            },
            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <button type="button" data-id="${r.id}" class="btn btn-primary restore" data-toggle="tooltip" data-placement="top" title="الرجوع عن الحذف"><i class="fas fa-trash-restore"></i></button>
                        <button type="button" data-id="${r.id}" data-permenant="true" class="btn btn-danger remove" data-toggle="tooltip" data-placement="top" title="حذف"><i class="fa fa-trash"></i></button>
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