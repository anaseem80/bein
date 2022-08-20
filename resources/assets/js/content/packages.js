$(document).ready(function() {
    var columns = [{
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
            data: "count",
            name: "count",
            render: function(d, t, r, m) {
                return r['subPackages'].length + ' باقة';
            }
        },
        {
            data: "action",
            name: "action",
            render: function(d, t, r, m) {
                $('[data-toggle="tooltip"]').tooltip();
                return `
            <a href="${dashboard_site}/package/${r.id}/edit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></a>
           
            <button type="button" data-id="${r.id}" class="btn btn-danger remove" data-toggle="tooltip" data-placement="top" title="حذف"><i class="fa fa-trash"></i></button>
        `;
            }
        },


    ];


    var packages = $('#packages').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        buttons: [{
            text: 'إضافة جديد',
            className: 'btn btn-primary pull-left',
            action: function(e, dt, node, config) {
                document.location.href = dashboard_site + '/package/create';
            }
        }],
        "pageLength": 25,
        "bInfo": true,
        "bLengthChange": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/package" + is_offer,
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
                data: "price",
                name: "price",
                render: function(d, t, r, m) {
                    return (r.price_365 != null ? r.price_365 : (r.price_180 != null ? r.price_180 : r.price_90)) + ' ' + currency
                }
            },

            {
                data: "devices",
                name: "devices",
                render: function(d, t, r, m) {
                    if (d.length == 1) {
                        return `<a href="${dashboard_site}/device/${d[0].id}/edit" target="_blank">${d[0].name}</a>`;
                    } else if (d.length == 0) {
                        return 'بدون';
                    } else {
                        var data = "";
                        for (var i = 0; i < d.length; i++) {
                            var ext = i == 0 ? "" : ", ";
                            data += ext + `<a href="${dashboard_site}/device/${d[i].id}/edit" target="_blank">${d[i].name}</a>`
                        }
                        return data;
                    }
                }
            },
            {
                data: "channels",
                name: "channels",
                render: function(d, t, r, m) {
                    var channels = '';
                    for (var i = 0; i < d.length; i++) {
                        var e = '';
                        if (i != 0) {
                            e = ', ';
                        }
                        channels += e + `<a href="${dashboard_site}/channel/${d[i].id}/edit" target="_blank">${d[i].name}</a>`;

                    }
                    return channels;
                }
            },
            {
                data: 'channelImages',
                name: 'channelImages',
                render: function(d, t, r, m) {
                    if (d.length > 0) {
                        return `<button type="button" class="btn btn-success viewImages" data-images='${JSON.stringify(d)}' data-channels='${JSON.stringify(r.channels)}'>${d.length}</button>`
                    } else {
                        return null;
                    }
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
            <a href="${dashboard_site}/package/${r.id}/edit?subpackages=true" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></a>
           
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

    $(document).on('click', '.viewImages', function() {
        var images = $(this).data('images');
        var channels = $(this).data('channels');

        $.dialog({
            title: '<p class="mt-2">عرض الصور</p>',
            columnClass: 'col-lg-8',
            content: function() {
                var content = '<div class="container-fluid"><div class="row p-3">';
                for (var img of images) {
                    var channel = channels.find(c => c.id == img.channel_id);
                    content += `
                    <div class="col-3">
                        <img src="${home_site}/${img.image}"  data-toggle="tooltip" data-placement="top"  title="${channel.name}" />
                    </div>
                    `
                }
                content += '</div></div>';
                setTimeout(function() {
                    $('img[data-toggle="tooltip"]').tooltip({
                        container: '.jconfirm-box'
                    });
                }, 100)
                return content;
            },
            backgroundDismiss: true,
        })
    })
})