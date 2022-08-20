$(document).ready(function() {
    var href = window.location.href;
    var tabs = $('a.collapse-item');
    $(tabs).each(function(e) {
        if ($(this).attr('href') == href) {
            $(this).parents('.collapse').addClass('show');
            $(this).addClass('alert-secondary');
        }
    })


});