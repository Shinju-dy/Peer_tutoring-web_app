$(document).ready(function() {
    // Fetch and update the unread notifications count every 1 second
    setInterval(fetchAndUpdateUnreadCount, 1000);
});

function fetchAndUpdateUnreadCount() {
    $.ajax({
        url: '../admin_backend/update_notification.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('.badge').text(data.unread_count);
        }
    });
}

