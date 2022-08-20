$(document).ready(function() {

    $(document).on('click', '.comments', function() {
        var comments = $(this).data('comments');
        var body = "";
        comments.forEach(c => {
            var date = new Date(c.created_at);
            body += `
                <tr id="row-${c.id}">
                    <td>${c.username}</td>
                    <td>${c.comment.length>30?'<span style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="رؤية المزيد" data-comment="'+c.comment+'" class="longComment">'+c.comment.substr(0,30)+'...</span>':c.comment}</td>
                    <td>${c.rate??''}</td>
                    <td>${date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()}</td>
                    <td><button type="button" data-id="${c.id}" data-type="comment" class="btn btn-danger remove" data-toggle="tooltip" data-placement="top" title="حذف"><i class="fa fa-trash"></i></button></td>
                </tr>
            `;
        })
        setTimeout(function() {
            $('[data-toggle="tooltip"]').tooltip({
                container: '.jconfirm-box-container.jconfirm-animated.jconfirm-no-transition'
            });
        }, 1000)
        $.dialog({
            columnClass: 'col-8',
            title: '<h3 class="mt-2">عرض التعليقات</h3>',
            content: `
            <table class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>التعليق</th>
                        <th>التقييم</th>
                        <th>التاريخ</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    ${body}
                </tbody>
            </table>
            `
        })
    })
    $(document).on('click', '.longComment', function() {
        var comment = $(this).data('comment');
        $.alert({
            title: '',
            content: `<p style="word-wrap: break-word;">${comment}</p>`,
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
    })

})