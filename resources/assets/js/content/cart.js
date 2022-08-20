var cartTable;
$(document).ready(function () {

    $(document).on('change keyup', '.cartCount', function () {
        var id = $(this).data('id');
        var count = $(this).val();
        var data = {
            '_token': csrf_token,
            'id': id,
            'count': count
        };
        $.post(change_cart_count, data, function (response) {
            if (response.success) {
                cartTable.ajax.reload();
                setCartTotalLabels();
            }
        })
    })
    $(document).on('click', '#refreshCart', function () {
        cartTable.destroy();
        initCartTable('#cartTable', true);
        setCartTotalLabels();
        setTimeout(function () {
            initCartTable('#cartTable')
        }, 500)
        getCartCounter();
    })
    setCartTotalLabels();

})


function initCartTable(id, processing = false) {
    cartTable = $(id).DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        paging: false,
        "bInfo": false,
        "bLengthChange": false,
        processing: processing,
        serverSide: true,
        destroy: true,
        "searching": false,
        ajax: {
            url: home_site + "/cartTable",
            type: "GET",
        },

        columns: [{
                data: 'delete',
                name: 'delete',
                render: function (d, t, r, m) {
                    return `
                <i class="fa fa-times text-danger remove" data-id="${r.id}" data-from="front" style="cursor:pointer"></i>
                `
                }
            },
            {
                data: "image",
                name: "image",
                render: function (d, t, r, m) {
                    if (d == null) {
                        return null;
                    } else {
                        return `
                            <img src="${home_site}/${d}" width="30" height="30">
                    `;
                    }
                }
            },
            {
                data: "name",
                name: "name",
                render: function (d, t, r, m) {
                    return `
                        <a href="${home_site}/package/${r.id}" class="text-decoration-none">${d}</a>
                `;
                }
            },

            {
                data: "price",
                name: "price",
                render: function (d, t, r, m) {
                    return d + ' ' + currency
                }
            },
            {
                data: "count",
                name: "count",
                render: function (d, t, r, m) {
                    return `
                        <input type="number" value="${d}" class="form-control m-auto cartCount" data-id="${r.id}" style="width: 60;">
                `;
                }
            },
            {
                data: "total",
                name: "total",
                render: function (d, t, r, m) {
                    return (r.price * r.count)+' '+currency;
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

}
