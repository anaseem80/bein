$(document).ready(function() {
    var channel_images = $('#channel_images').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        "pageLength": 25,
        "bInfo": true,
        "bLengthChange": false,
        "searching": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/channel/" + channel_id + '/edit',
            type: "GET",
        },

        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex"
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
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <button type="button" data-id="${r.id}" class="btn btn-danger remove" data-toggle="tooltip" data-placement="top" title="حذف"><i class="fa fa-trash"></i></button>
                    `;
                }
            },


        ],
        columnDefs: [{
                targets: [0, 1, 2],
                searchable: true
            },

        ],
        ordering: false,
    })
})