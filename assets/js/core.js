$(document).ready(function() {
    // For correct view
    window.scrollTo(0, 0);

    if (typeof $('.channelTabs')[1] != "undefined") {
        $('.channelTabs')[1].click();
        $('.channelTabs')[0].click();
    }

    if (typeof $('.channelTabs')[0] != "undefined") {
        // Message refresh
        refreshLogs();
        setInterval(refreshLogs, 1000);
    }
    // some nice key mapping functions
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
                    //console.log(data);
                }
            });

            $('.message').val('');
        }
    });

    // Change channels by strike arrow keys - currently maybe a little bit dirty
    $(document).keyup(function(e) {
        if (e.keyCode === 37) {
            // Tab left
            $('#' + (parseInt($('li.active > a').attr('id')) - 1)).click();
        }

        if (e.keyCode === 39) {
            // Tab right
            $('#' + (parseInt($('li.active > a').attr('id')) + 1)).click();
        }
    });
    // some nice key mapping functions end

    // Message refresh - each channel you are in
    function refreshLogs() {
        var postDataMessage = {flushAllChannels: true};
        $.ajax({
            url: "/message/recive/",
            type: "POST",
            data: postDataMessage,
            dataType: 'json',
            success: function(data) {
                // Foreach joined channels
                $.each(data, function(chatName, messages) {
                    // Set current channel
                    var currentChatTab = '.chat_' + chatName;

                    // Truncate log
                    $(currentChatTab).html('');

                    // Create new log foreach message
                    $.each(messages, function(messageNum, messageArr) {
                        $(currentChatTab).append("[" + messageArr.timestamp + "]  <a  data-toggle='modal' data-target='#setcard' class='user chatUser level" + messageArr.level + "'>" + messageArr.username + "</a>: " + messageArr.message + "<br/>");
                    });
                    $(".contentChat").scrollTop($('.contentChat')[0].scrollHeight);
                });
                regHooks();
            }
        });
    }

    // Sets hook on each user
    function regHooks() {
        // Ajax request to load infos into setcard
        $('.chatUser').off("click");
        $('.chatUser').on("click", function() {
            var userClick = $(this);
            var postDataMessage = {user: userClick.html()};
            $.ajax({
                url: "/profile/show/",
                type: "POST",
                data: postDataMessage,
                dataType: 'json',
                success: function(data) {
                    // Render data in modal
                    console.log(data);
                    // Check, if user not found
                    if(data.message) {
                        $('.setcard_name').html(data.message);
                        exit;
                    }
                    
                    // Realname
                    if (!!data.realName) {
                        $('.setcard_name').html(data.realName + ' alias "' + userClick.html() + '"');
                    } else {
                        $('.setcard_name').html(userClick.html());
                    }
                    
                    // Birthdate
                    if(data.birthdate != '0000-00-00') {
                        $('.setcard_born').html('Born in: ' + data.birthdate);
                    }
                    
                    // Bio
                    if (!!data.bio) {
                        $('.setcard_bio').html(data.bio);
                    }
                    
                    // Avatar
                    if(!!data.avatar) {
                        $('.setcard_picture').html('<img class="setcartd_picture_src img-circle" src="' + window.location.href + data.avatar + '"/>');
                    }                    
                }
            });
        });
    }

    // Topic change
    var chan = '.topic_' + $('.nav > .active > a').html();
    $('.topic').click(function() {
        // Change Input topic placeholder
        $('.topicName').attr('placeholder', $(chan).html());
        $('.hiddenChannelValue').val($('.nav > .active > a').html());
    });

    // ...
});
