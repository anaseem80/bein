$(document).ready(function() {
    var orders = $('#orders').DataTable({
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
            url: dashboard_site + "/orders",
            type: "GET",
            data: {
                'package_type': function() { return $('input[name="package_type"]:checked').val(); }
            }
        },

        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex"
            },
            {
                data: "created_at",
                name: "created_at",
                render: function(d, t, r, m) {
                    var date = new Date(d)
                    return date.getFullYear() + "/" + (date.getMonth() + 1) + "/" + date.getDate()
                }
            },
            {
                data: "user_id",
                name: "user_id",
                render: function(d, t, r, m) {
                    return d == null ? 'غير مسجل' : 'مسجل';
                }
            },
            {
                data: "first_name",
                name: "first_name"
            },
            {
                data: "last_name",
                name: "last_name"
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
                data: "country.name",
                name: "country.name"
            },
            {
                data: "id",
                name: "id"
            },
            {
                data: "invoice_number",
                name: "invoice_number"
            },
            {
                data: "transaction_id",
                name: "transaction_id"
            },
            {
                data: "invoice_status",
                name: "invoice_status",
                render: function(d, t, r, m) {
                    var text_color = '';
                    switch (d) {
                        case 'PAID':
                            text_color = 'success';
                            break;
                        case 'CREATED':
                        case 'SAVED':
                            text_color = 'info';
                            break;
                        case 'EXPIRED':
                            text_color = 'warning';
                            break;
                        case 'CANCELLED':
                            text_color = 'danger';
                            break;
                    }
                    return `<span class="text-${text_color}">${d}</span>`;
                }
            },
            {
                data: "duration",
                name: "duration",
                render: function(d, t, r, m) {
                    return d + ' يوم';
                }
            },

            {
                data: "package_type",
                name: "package_type",
                render: function(d, t, r, m) {
                    return d == 'new' ? 'اشتراك جديد' : 'تجديد اشتراك';
                }
            },
            {
                data: "bein_card_number",
                name: "bein_card_number",
                render: function(d, t, r, m) {
                    if (r.package_type == 'renew') {
                        return d;
                    } else {
                        return '<span class="text-secondary">-</span>'
                    }
                }
            },
            {
                data: "package.name",
                name: "package.name",
                render: function(d, t, r, m) {
                    return `<a target="_blank" href="${dashboard_site}/package/${r.package_id}/edit" title="تفاصيل الباقة">${d}</a>`;
                }
            },

            {
                data: "sub_total",
                name: "sub_total",
                render: function(d, t, r, m) {
                    return d + ' ' + r.invoice_details?.currency;
                }
            },
            {
                data: "device",
                name: "device",
                render: function(d, t, r, m) {
                    if (r.package_type == 'new'&&d) {
                        return `<a target="_blank" href="${dashboard_site}/device/${d.id}/edit" title="تفاصيل الجهاز">${d.name}</a>`;
                    } else {
                        return '<span class="text-secondary">-</span>'
                    }
                }
            },
            {
                data: "device_price",
                name: "device_price",
                render: function(d, t, r, m) {
                    if (r.package_type == 'new') {
                        return d + ' ' + r.invoice_details?.currency;
                    } else {
                        return '<span class="text-secondary">-</span>'
                    }
                }
            },
            {
                data: "shipping",
                name: "shipping",
                render: function(d, t, r, m) {
                    if (r.package_type == 'new') {
                        return d + ' ' + r.invoice_details?.currency;
                    } else {
                        return '<span class="text-secondary">-</span>'
                    }
                }
            },
            {
                data: "taxes",
                name: "taxes",
                render: function(d, t, r, m) {
                    return d + ' ' + r.invoice_details?.currency;
                }
            },
            {
                data: "total",
                name: "total",
                render: function(d, t, r, m) {
                    return d + ' ' + r.invoice_details?.currency;
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
    $(document).on('change', 'input[name="package_type"]', function() {
        orders.ajax.reload();
    })
})