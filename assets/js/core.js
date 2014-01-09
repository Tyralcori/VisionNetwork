$(document).ready(function() {
    // For correct view
    $('.channelTabs')[1].click();
    $('.channelTabs')[0].click();
    
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
    var postDataMessage = {flushAllChannels: true};
    $.ajax({
        url: "/message/recive/",
        type: "POST",
        data: postDataMessage,
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
    });

    // Topic change
    var chan = '.topic_' + $('.nav > .active > a').html();
    $('.topic').click(function() {
        // Change Input topic placeholder
        $('.topicName').attr('placeholder', $(chan).html());
        $('.hiddenChannelValue').val($('.nav > .active > a').html());
    });
    // ...
});