$(document).ready(function() {
    var sliders = $('#sliders').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        buttons: [{
            text: 'إضافة جديد',
            className: 'btn btn-primary pull-left mb-2',
            action: function(e, dt, node, config) {
                $.dialog({
                    title: '',
                    content: `
                    <div id="slider-loader" class="hidden position-absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index:1;background: rgba(255,255,255,.5)">
                    <div class="spinner-border text-primary" style="width:5rem !important;height:5rem !important;" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div>
                    </div>
                    <div class="w-100 p-2 overflow-hidden position-relative">
                    <h3 class="mt-2">إضافة غلاف جديد</h3>
                    <form id="slider-form" method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="form-group col-12">
                    <label>الصورة</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control" id="slider-image" name="slider-image" accept="image/*" required>
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>العنوان</label><span class="text-danger"> *</span>
                    <textarea autocomplete="off" class="form-control" id="slider-title" name="slider-title" required></textarea>
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>رابط تجديد الاشتراك</label><span class="text-danger"> *</span>
                    <input autocomplete="off" type="text" class="form-control" id="slider-url" name="slider-url" required>
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>رابط الاشتراك الجديد</label>
                    <input autocomplete="off" type="text" class="form-control" id="slider-url2" name="slider-url2" >
                    </div>
                    <div class="form-group col-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary" id="slider-save">حفظ</button>
                    </div>
                    </div>
                    </form>
                    </div>
                    `,
                });
            }
        }],
        "pageLength": 5,
        "bInfo": true,
        "bLengthChange": false,
        "searching": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/slidersList",
            type: "GET",
        },

        columns: [

            {
                data: "key",
                name: "key",
                render: function(d, t, r, m) {
                    if (d == null) {
                        return null;
                    } else {
                        return `
                        <img title="عرض الصورة" class="open-image" style="cursor:pointer;" src="${home_site}/${d}" width="90" height="90">
                        `;
                    }
                }
            },
            {
                data: "value",
                name: "value"
            },
            {
                data: "description",
                name: "description"
            },
            {
                data: "description_2",
                name: "description_2"
            },
            {
                data: "status",
                name: "status",
                render: function(d, t, r, m) {
                    return `
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input title="${d==1?'الغاء النشر':'نشر'}" style="cursor:pointer" class="form-check-input change-published" ${d==1?'checked':''} type="checkbox" data-id="${r.id}">
                    </div>
                    `;
                }
            },
            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <button data-id="${r.id}" data-title="${r.value}" data-url="${r.description}" data-url2="${r.description_2}" class="btn btn-primary slider-edit" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></button>
                       
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

    var taxes = $('#orderTaxes').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        buttons: [{
            text: 'إضافة جديد',
            className: 'btn btn-primary pull-left mb-2',
            action: function(e, dt, node, config) {
                $.dialog({
                    title: '',
                    content: `
                    <div id="tax-loader" class="hidden position-absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index:1;background: rgba(255,255,255,.5)">
                    <div class="spinner-border text-primary" style="width:5rem !important;height:5rem !important;" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div>
                    </div>
                    <div class="w-100 p-2 overflow-hidden position-relative">
                    <h3 class="mt-2">إضافة مصاريف جديدة</h3>
                    <form id="tax-form" method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="form-group col-12">
                    <label>العنوان</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" id="tax-title" name="tax-title" required>
                    </div>
                    <div class="form-group col-6 mt-2">
                    <label>القيمة</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control numeric" id="tax-value" name="tax-value" required></ه>
                    </div>
                    <div class="form-group col-6 mt-2">
                    <label>نوع القيمة</label><span class="text-danger"> *</span>
                    <select class="form-control" id="tax-type" name="tax-type" required>
                        <option value="number">قيمة صحيحة</option>
                        <option value="percent">نسبة مئوية</option>
                    </select>
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>عرض في تفاصيل الطلب</label>
                    <div class="form-check form-switch ">
                    <input style="cursor:pointer" class="form-check-input" type="checkbox" id="tax-shown" value="1">
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>تفعيل</label>
                    <div class="form-check form-switch ">
                    <input style="cursor:pointer" class="form-check-input" type="checkbox" id="tax-published" value="1">
                    </div>
                    </div>
                    <div class="form-group col-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary" id="tax-save">حفظ</button>
                    </div>
                    </div>
                    </form>
                    </div>
                    `,
                });
            }
        }],
        "pageLength": 5,
        "bInfo": true,
        "bLengthChange": false,
        "searching": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/taxes",
            type: "GET",
        },

        columns: [

            {
                data: "key",
                name: "key"
            },
            {
                data: "value",
                name: "value"
            },
            {
                data: "description",
                name: "description",
                render: function(d, t, r, m) {
                    if (d == 'number') {
                        return 'قيمة صحيحة'
                    } else {
                        return 'نسبة مئوية'
                    }
                }
            },
            {
                data: "description_2",
                name: "description_2",
                render: function(d, t, r, m) {
                    return `
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input title="${d==1?'اخفاء':'عرض'}" style="cursor:pointer" class="form-check-input change-tax" data-col="description_2" ${d==1?'checked':''} type="checkbox" data-id="${r.id}">
                    </div>
                    `;
                }
            },
            {
                data: "status",
                name: "status",
                render: function(d, t, r, m) {
                    return `
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input title="${d==1?'الغاء التفعيل':'تفعيل'}" style="cursor:pointer" class="form-check-input change-tax" data-col="status" ${d==1?'checked':''} type="checkbox" data-id="${r.id}">
                    </div>
                    `;
                }
            },
            {
                data: "action",
                name: "action",
                render: function(d, t, r, m) {
                    $('[data-toggle="tooltip"]').tooltip();
                    return `
                        <button data-id="${r.id}" data-title="${r.key}" data-value="${r.value}" data-type="${r.description}" data-shown="${r.description_2}" data-published="${r.status}" class="btn btn-primary tax-edit" data-toggle="tooltip" data-placement="top" title="تعديل"><i class="fa fa-edit"></i></button>
                       
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


    $('#slider-form').validate({
        rules: {
            key: "required",
            value: "required",
            description: "required",
        },
        messages: {
            key: "برجاء اختيار صورة",
            value: "برجاء إدخال عنوان",
            description: "برجاء إدخال رابط",
        }
    })

    $('#tax-form').validate({
        rules: {
            key: "required",
            value: "required",
            description: "required",
        },
        messages: {
            key: "برجاء اختيار صورة",
            value: "برجاء إدخال عنوان",
            description: "برجاء إدخال رابط",
        }
    })
    $(document).on('click', '.slider-edit', function() {
        var id = $(this).data('id');
        var url = $(this).data('url');
        var url2 = $(this).data('url2');
        var title = $(this).data('title');
        if (url == 'null' || url == null) {
            url = "";
        }
        if (url2 == 'null' || url2 == null) {
            url2 = "";
        }
        $.dialog({
            title: '',
            content: `
            <div id="slider-loader" class="hidden position-absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index:1;background: rgba(255,255,255,.5)">
            <div class="spinner-border text-primary" style="width:5rem !important;height:5rem !important;" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            </div>
            <div class="w-100 p-2 overflow-hidden position-relative">
            <h3 class="mt-2">تعديل الغلاف </h3>
            <form id="slider-form" method="post" enctype="multipart/form-data">
            <input type="hidden" id="slider-id" value="${id}">
            <div class="row">
            <div class="form-group col-12">
            <label>الصورة</label><span class="text-danger"> *</span>
            <input type="file" class="form-control" id="slider-image" name="slider-image" >
            </div>
            <div class="form-group col-12 mt-2">
            <label>العنوان</label><span class="text-danger"> *</span>
            <textarea autocomplete="off" class="form-control" id="slider-title" name="slider-title" required>${title}</textarea>
            </div>
            <div class="form-group col-12 mt-2">
            <label>رابط تجديد الاشتراك</label><span class="text-danger"> *</span>
            <input autocomplete="off" type="text" class="form-control" id="slider-url" name="slider-url" value="${url}" required>
            </div>
            <div class="form-group col-12 mt-2">
            <label>رابط الاشتراك الجديد</label>
            <input autocomplete="off" type="text" class="form-control" id="slider-url2" name="slider-url2" value="${url2}" >
            </div>
            <div class="form-group col-12 text-end mt-2">
            <button type="submit" class="btn btn-primary" id="slider-save">حفظ</button>
            </div>
            </div>
            </form>
            </div>
            `,
        });
    });
    $(document).on('click', '.tax-edit', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var value = $(this).data('value');
        var type = $(this).data('type');
        var shown = $(this).data('shown');
        var published = $(this).data('published');

        $.dialog({
            title: '',
            content: `
            <div id="tax-loader" class="hidden position-absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index:1;background: rgba(255,255,255,.5)">
                    <div class="spinner-border text-primary" style="width:5rem !important;height:5rem !important;" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div>
                    </div>
                    <div class="w-100 p-2 overflow-hidden position-relative">
                    <h3 class="mt-2">تعديل مصاريف </h3>
                    <form id="tax-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="tax-id" value="${id}">

                    <div class="row">
                    <div class="form-group col-12">
                    <label>العنوان</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" id="tax-title" name="tax-title" value="${title}" required>
                    </div>
                    <div class="form-group col-6 mt-2">
                    <label>القيمة</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control numeric" id="tax-value" name="tax-value" value="${value}" required></ه>
                    </div>
                    <div class="form-group col-6 mt-2">
                    <label>نوع القيمة</label><span class="text-danger"> *</span>
                    <select class="form-control" id="tax-type" name="tax-type" required>
                        <option value="number" ${type=='number'?'selected':''}>قيمة صحيحة</option>
                        <option value="percent" ${type=='percent'?'selected':''}>نسبة مئوية</option>
                    </select>
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>عرض في تفاصيل الطلب</label>
                    <div class="form-check form-switch ">
                    <input style="cursor:pointer" class="form-check-input" type="checkbox" value="1" id="tax-shown" ${shown==1?'checked':''}>
                    </div>
                    <div class="form-group col-12 mt-2">
                    <label>تفعيل</label>
                    <div class="form-check form-switch ">
                    <input style="cursor:pointer" class="form-check-input" type="checkbox" value="1" id="tax-published" ${published==1?'checked':''}>
                    </div>
                    </div>
                    <div class="form-group col-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary" id="tax-save">حفظ</button>
                    </div>
                    </div>
                    </form>
                    </div>
            `,
        });
    });
    $(document).on('submit', '#tax-form', function(e) {
        e.preventDefault();
        $('#tax-loader').removeClass('hidden');
        var id = $('#tax-id').val();
        var title = $('#tax-title').val();
        var value = $('#tax-value').val();
        var type = $('#tax-type').val();
        var shown = $('#tax-shown:checked').val();
        var published = $('#tax-published:checked').val();

        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': id,
            'title': title,
            'value': value,
            'type': type,
            'shown': shown,
            'published': published
        }
        $.post(storeTax, data, function(response) {
            if (response.success) {
                $('#slider-loader').addClass('hidden');
                taxes.ajax.reload();
                $('.jconfirm-closeIcon').click();
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
            }
        })


    });
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
                    content: response.status == 0 ? 'تم إلغاء العرض في الشاشة الرئيسية ' : 'تم العرض في الشاشة الرئيسية',
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
    $(document).on('change', '.change-tax', function() {
        var id = $(this).data('id');
        var column = $(this).data('col');
        var value = 0;
        $(this).attr('title', column == 'status' ? 'تفعيل' : 'عرض');
        if ($(this).prop('checked')) {
            value = 1;
            $(this).attr('title', column == 'status' ? 'إلغاء التفعيل' : 'إلغاء العرض');
        }
        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': id,
            'column': column,
            'value': value
        };
        $.post(change_tax, data, function(response) {
            if (response.success) {
                taxes.ajax.reload();
                $.alert({
                    title: '',
                    content: value == 1 ? (column == 'status' ? 'تم تفعيل المصاريف ليتم إضافتها على الفاتورة' : 'تم عرض المصاريف في تفاصيل الطلب ') : (column == 'status' ? 'تم إلغاء تفعيل المصاريف' : 'تم إلغاء عرض المصاريف في تفاصيل الطلب '),
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
    $(document).on('click', '.open-image', function() {
        var src = $(this).attr('src');
        $.dialog({
            backgroundDismiss: true,
            columnClass: 'col-md-12',
            title: '<label class="mt-2">عرض الصورة</label>',
            content: `
            <div class="d-flex justify-content-center align-items-center">
            <img src="${src}">
            </div>
            `
        })
    })
    var packageOptions = "";
    packages.forEach(p => {
        packageOptions += `
        <option value="${p.id}">${p.name}</option>
        `
    })

    function formatPackages(package) {
        if (!package.id) {
            return package.text;
        }
        var img = packages.find(p => p.id == package.id).logo;
        var $package = $(
            '<span class="d-flex justify-content-between">' + package.text + (img ? '<img  src="' + home_site + '/' + img + '" width="50" height="50" />' : '') + '</span>'
        );
        return $package;
    };

    var mainPackages = $('#packages').DataTable({
        dom: "lBfrtip",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json"
        },
        buttons: [{
            text: 'إضافة جديد',
            className: 'btn btn-primary pull-left mb-2',
            action: function(e, dt, node, config) {
                setTimeout(function() {
                    $('.packages').select2();


                    $('.packages').select2({
                        templateResult: formatPackages
                    })
                }, 100)
                $.dialog({
                    title: '',
                    content: `
                    <div id="slider-loader" class="hidden position-absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index:100000001;background: rgba(255,255,255,.5)">
                    <div class="spinner-border text-primary" style="width:5rem !important;height:5rem !important;" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div>
                    </div>
                    <div class="w-100 p-2 overflow-hidden position-relative">
                    <h4 class="mt-2">إضافة أهم الباقات للصفحة الرئيسية </h4>
                    <div class="row">
                    <div class="form-group col-12">
                    <label>الباقة</label><span class="text-danger"> *</span>
                    <select id="packageId" class="packages form-control">
                    ${packageOptions}
                    </select>
                    </div>
                    <div class="form-group col-12 text-end mt-2">
                    <button type="button" class="btn btn-primary" id="package-save">حفظ</button>
                    </div>
                    </div>
                    `,
                });
            }
        }],
        "pageLength": 5,
        "bInfo": true,
        "bLengthChange": false,
        "searching": false,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: dashboard_site + "/mainPackages",
            type: "GET",
        },

        columns: [

            {
                data: "name",
                name: "name",
            },

            {
                data: "image",
                name: "image",
                render: function(d, t, r, m) {
                    if (d == null) {
                        return null;
                    } else {
                        return `
                        <img title="عرض الصورة" class="open-image" style="cursor:pointer;" src="${home_site}/${d}" width="90" height="90">
                        `;
                    }
                }
            },
            {
                data: "price",
                name: "price",
                render: function(d, t, r, m) {
                    return r.price_365
                }
            },
            {
                data: "description",
                name: "description",
                render: function(d, t, r, m) {
                    if (d == null) {
                        return d;
                    }
                    if (d.length > 30) {
                        $('[data-toggle="tooltip"]').tooltip();
                        return `<p data-toggle="tooltip" style="cursor:pointer;" class="longComment" data-placement="top" title="رؤية المزيد" data-comment="${d}">${d.substring(0,30)+'...'}</p>`
                    } else {
                        return d;
                    }
                }
            },
            {
                data: "status",
                name: "status",
                render: function(d, t, r, m) {
                    return `
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input title="${d==1?'الغاء النشر':'نشر'}" style="cursor:pointer" class="form-check-input change-published" ${d==1?'checked':''} type="checkbox" data-id="${r.id}">
                    </div>
                    `;
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
                targets: [0, 1, 2, 3],
                searchable: true
            },

        ],
        ordering: false,
    })
    $(document).on('submit', '#slider-form', function(e) {
        e.preventDefault();
        $('#slider-loader').removeClass('hidden');
        var id = $('#slider-id').val();
        var title = $('#slider-title').val();
        var url = $('#slider-url').val();
        var url2 = $('#slider-url2').val();
        var image = $('#slider-image')[0].files
        var data = new FormData();

        if (id > 0) {
            data.append('id', id);
            if (image.length > 0) {
                data.append('image', image[0]);
            }
        } else {
            data.append('image', image[0]);
        }
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('title', title);
        data.append('url', url);
        data.append('url2', url2);

        $.ajax({
            url: storeSlider,
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#slider-loader').addClass('hidden');
                    sliders.ajax.reload();
                    $('.jconfirm-closeIcon').click();
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
                    })
                }
            }
        });
    });

    $(document).on('click', '#package-save', function() {
        $('#slider-loader').removeClass('hidden');
        var packageId = $('#packageId').val();
        var data = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'packageId': packageId
        };
        $.post(storeMainPackage, data, function(response) {
            $('#slider-loader').addClass('hidden');
            $('.jconfirm-closeIcon').click();
            $.alert({
                title: '',
                content: response.message,
                type: response.success ? 'blue' : 'red',
                backgroundDismiss: true,
                buttons: {
                    cancel: {
                        text: 'حسنًا',
                        btnClass: 'btn-blue',
                        action: function() {}
                    }
                }
            })
            if (response.success) {
                mainPackages.ajax.reload();
            } else {

            }
        })
    })





})