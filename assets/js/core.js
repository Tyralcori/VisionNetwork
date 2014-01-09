$(document).ready(function() {
    // Message SEND
    $('.message').keyup(function(e) {
        if (e.keyCode === 13) {

            var newName = $('.nav > .active > a').html();
            $.ajax({
                url: "/message/publish",
                data: {
                    message: $('.message').val(),
                    channel: newName,
                },
                dataType: "JSON",
                type: "POST",
                success: function(data) {
                    console.log(data);
                }
            });

            $('.message').val('');
        }
    });

    // Message refresh - each channel you are in
    var postData = {flushAllChannels: true};
    $.ajax({
        url: "http://dev.portfolio.de/message/recive/",
        type: "POST",
        data: postData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
    });

    // ...
});