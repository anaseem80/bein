$(document).ready(function() {

    function formatDevices(device) {
        if (!device.id) {
            return device.text;
        }
        var img = devices.find(d => d.id == device.id).image;
        var $device = $(
            '<span class="d-flex justify-content-between">' + device.text + (img ? '<img  src="' + home_site + '/' + img + '" width="50" height="50" />' : '') + ' </span>'
        );
        return $device;
    };



    function formatChannels(channel) {
        if (!channel.id) {
            return channel.text;
        }
        var img = channels.find(c => c.id == channel.id).image;
        var $channel = $(
            '<span class="d-flex justify-content-between">' + channel.text + (img ? '<img  src="' + home_site + '/' + img + '" width="50" height="50" />' : '') + '</span>'
        );
        return $channel;
    };
    setSelect2Images()

    function setSelect2Images() {
        $('.channels').select2({
            templateResult: formatChannels
        })

        $('.devices').select2({
            templateResult: formatDevices
        })
    }
    $(document).on('click', '#addSubPackageBtn', function() {
        setTimeout(function() {
            $('.select2').select2();
            setSelect2Images()
        }, 300)
    })
    $('.accordion-button').on('click', function() {
        setTimeout(function() {

            $('.devices').select2();
            $('.channels').select2();
            $('.channels').select2({
                templateResult: formatChannels
            })
            $('.devices').select2({
                templateResult: formatDevices
            })
        }, 1000)
    })
    $(`${window.location.hash}`).find('button.accordion-button').click();

    $(document).on('select2:select', '.channels', function(e) {
        var id = $(this).data('id');
        var data = e.params.data;
        var selected_channel = channel_images.find(c => c.channel_id == data.id);
        if (selected_channel.images.length > 0) {
            var appended = "";
            for (var img of selected_channel.images) {
                appended += `<div class="col-3 mt-2">
                <input id="ch-${id}-${img.id}" data-channel_id="${data.id}" data-id="${id}" type="checkbox" checked name="images[]" class="checkImage" multiple value="${img.id}">
                <label for="ch-${id}-${img.id}"><img width="50" height="50" src="${home_site}/${img.image}"></label>
                            </div>`
            }
            $(`#channelImagesView${id}`).append(`
            <div id="channelView${id}-${selected_channel.channel_id}">
            <h3>${data.text}</h3>
            <button type="button" class="btn btn-primary checkAll" id="checkBtn${selected_channel.channel_id}" data-channel_id="${data.id}" data-id="${id}" data-type="uncheck">إلغاء تحديد الكل</button>
            <div id="channels-${selected_channel.channel_id}" class="row mb-5">
                ${appended}
            </div>
            </div>
            `)
        }
        imagesCount(id);
    })
    $(document).on('select2:unselect', '.channels', function(e) {
        var id = $(this).data('id');
        var data = e.params.data;
        $(`#channelImagesView${id} #channelView${id}-${data.id}`).remove();
        imagesCount(id);
    })
    $(document).on('click', '.checkAll', function(e) {
        var type = $(this).attr('data-type');
        var id = $(this).attr('data-id');
        var channel_id = $(this).attr('data-channel_id');
        $(this).removeAttr('data-type');
        if (type == 'check') {
            $(this).attr('data-type', 'uncheck');
            $(this).text('إلغاء تحديد الكل');
            $(this).siblings(`div#channels-${channel_id}`).find('input[type="checkbox"]').prop('checked', true);
        } else {
            $(this).attr('data-type', 'check');
            $(this).text('تحديد الكل');
            $(this).siblings(`div#channels-${channel_id}`).find('input[type="checkbox"]').prop('checked', false);
        }
        imagesCount(id);
    })
    $(document).on('change', '.checkImage', function() {
        var id = $(this).data('id');
        var channel_id = $(this).data('channel_id');
        var checkBtn = $(`#checkBtn${channel_id}`);
        startCheckAll();
        imagesCount(id);
    })

    function imagesCount(id) {
        var checked = $(`#channelImagesView${id} input.checkImage[type="checkbox"]:checked`);
        $(`#imagesCount${id}`).text('(' + checked.length + ')');
    }
    startCheckAll();

    function startCheckAll() {
        $('.checkAll').each(function(e) {
            var id = $(this).attr('data-id');
            var channel_id = $(this).attr('data-channel_id');
            var allImages = $(`input.checkImage[data-channel_id="${channel_id}"]`).length;
            var allCheckedImages = $(`input.checkImage[data-channel_id="${channel_id}"]:checked`).length;
            if (allImages > allCheckedImages) {
                $(this).attr('data-type', 'check');
                $(this).text('تحديد الكل');
            } else {
                $(this).attr('data-type', 'uncheck');
                $(this).text('إلغاء تحديد الكل');
            }
        })
    }
})