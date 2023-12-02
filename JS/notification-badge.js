function updateUnreadCount() {
    $.ajax({
        url: '../user_backend/fetch_unread_count.php',
        type: 'GET',
        dataType: 'text',
        success: function (data) {
            console.log(data)
            const unreadCount = parseInt(data);
            $('.badge-notification').text(unreadCount).show();
        }
    });
}

$(document).ready(function () {
    updateUnreadCount();
    setInterval(updateUnreadCount, 1000);
});

