$(document).ready(function() {
    $('#add-form').validate({
        rules: {
            comment: "required",

            email: "required",

            name: "required",

        },
        messages: {
            comment: "برجاء إدخال تعليق",
            name: "برجاء إدخال الاسم",
            email: "برجاء إدخال البريد الإليكتروني",
        }
    });
    $(document).on('click', '#add-comment', function(e) {
        $("#add-form").submit(function(e) {
            e.preventDefault();
        });
        if ($('#add-form').valid()) {

            var comment = $('#comment').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var type = $(this).data('type');
            var item_id = $(this).data('id');
            var data = {
                '_token': csrf_token,
                'comment': comment,
                'username': name,
                'email': email,
                'type': type,
                'item_id': item_id
            };
            $.post(add_comment, data, function(response) {
                $('#comment').val('');
                $('#comment-container').prepend($('<div id="placeholder"></div>'));
                var placeholderHeight = 0;
                var min_height = 120;
                if ($('.comment-item').length) {
                    min_height = $('.comment-item').css('height').replace('px', '') * 1;
                }
                var interval = setInterval(function() {
                    placeholderHeight += 10;
                    if (placeholderHeight < min_height) {
                        $('#placeholder').css('height', `${placeholderHeight}px`);
                    } else {
                        clearInterval(interval);
                        $('#placeholder').prepend($(addComment(response.comment)));
                        $('#comment-container').prepend($('#placeholder').html());
                        $('#placeholder').remove();
                    }
                }, 20)
            })
        }
    })

})

function addComment($comment) {
    var delete_comment = '';
    if (manager == 1 || manager) {
        delete_comment = `
        <button class="btn btn-transparent remove-comment remove"
        data-id="${ $comment.id }" data-type="comment" data-from="front"><i
        class="fa fa-trash text-danger"></i></button>
        `;
    }

    return `
    <div id="row-${$comment.id}" class="col-12 comment-item row position-relative" data-id="${ $comment.id }">
        <div class="col-lg-3">
            <img
                src="${home_site+'/'+ ($comment.user?($comment.user['avatar'] ? $comment.user['avatar'] : 'resources/front/images/user.png') : 'resources/front/images/user.png') }" />
        </div>
        <div class="col-lg-9 row">
            ${delete_comment}
            <div class="col-12 text-primary">
                ${ $comment.comment }
            </div>
            <div class="col-12 header row text-secondary">
                <div class="col-4">
                    <i class="fa fa-user"></i>
                    ${ $comment.username ?? 'مجهول' }
                </div>
                <div class="col-4">
                    <i class="fa fa-envelope"></i>
                    ${ $comment.email ?? ' ' }
                </div>
                <div class="col-4">
                    <i class="fa fa-clock"></i>
                    الآن
                </div>
            </div>
        </div>
    </div>
    `;
}