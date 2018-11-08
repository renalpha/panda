window.jQuery(document).ready(function () {
    if (Laravel.groupId) {
        console.log('Listening to group: ' + Laravel.groupId);
        Echo.private('users.group.notification.' + Laravel.groupId)
            .listen('PandaGroupCommentNotificationCreated', (data) => {
                window.jQuery('*[data-comment="' + data.comment.commentable_id + '"]').prepend(commentToAppend(data))
            })
            .listen('PandaNewActivityCreated', (data) => {
                console.log('pand activity');
                window.jQuery('#notificationUpdate').fadeIn();
            });
    }

    window.jQuery(document).on('submit', '.replyForm', function () {

        var formData = new FormData($(this)[0]);

        window.jQuery.ajax({
            url: $(this).attr('action'),
            method: 'post',
            processData: false, // important
            contentType: false, // important
            data: formData,
        });

        $(this)[0].reset();

        return false;
    });
});

/**
 * Comment to append.
 *
 * @param data
 * @returns {string}
 */
function commentToAppend(data) {

    var commentData = $.parseJSON(data.comment.data);

    return '<li>\n' +
        '<div class="commenterImage">\n' +
        '    <img src="' + commentData.profile_picture + '" alt="User" />\n' +
        '    </div>\n' +
        '    <div class="commentText">\n' +
        '    <p><strong>' + commentData.name + '</strong></p>\n' +
        '<p>' + commentData.comment + '</p>\n' +
        '<span class="date sub-text">on ' + data.comment.created_at_humans + ' \n' +
        '</span>\n' +
        '</div>\n' +
        '</li>';
}