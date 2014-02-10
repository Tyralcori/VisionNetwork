$(document).ready(function() {
    // For correct view
    window.scrollTo(0, 0);

    if (typeof $('.channelTabs')[1] != "undefined") {
        $('.channelTabs')[1].click();
        $('.channelTabs')[0].click();
    }
    
    // Count registerd user
    if(typeof $('.user') != "undefined") {
        $('.userReg').countTo({from: 0, to: 500});
        $('.channel').countTo({from: 0, to: 2000});
        $('.messages').countTo({from: 0, to: 50000});
    }

    // Show messagebox on every tab excluding system tab
    $('.channelTabs').click(function() {
        $('.message').css('display', 'block');
    });
    // No inputbox (message) on system channel
    $('.tab_system').click(function() {
        $('.message').css('display', 'none');
    });

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
                    if (typeof data.message != "undefined") {
                        privateMessageSystem(data);
                    }
                }
            });

            $('.message').val('');
        }
    });

    // New array for some nice internal messages
    var internalMessage = new Array();

    // Add a message into internal array
    function privateMessageSystem(messageAdd) {
        if (typeof internalMessage.length == "undefined") {
            countBean = 0;
        } else {
            countBean = internalMessage.length;
        }

        internalMessage[countBean] = {};
        internalMessage[countBean].message = messageAdd.message;
        internalMessage[countBean].timestamp = messageAdd.timestamp;

        // Create new log foreach message
        $('.systemLogChat').append("[" + messageAdd.timestamp + "] SYSTEM: " + messageAdd.message + "<br/>");
        highlight('system');
    }

    // Highlight a channel
    function highlight(channel) {
        if (channel.length > 0) {
            var prefix = "tab_";
            var completeChannel = prefix + channel;
            // Add highlightChannel class for channel
            $('.' + completeChannel + ' > .channelTabs').addClass('highlightChannel');
            // Remove highlight onclick highlighted channel
            $('.highlightChannel').click(function() {
                $(this).removeClass('highlightChannel');
            });
        }
    }

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
                        if(messageArr.colorCode) {
                            $(currentChatTab).append("[" + messageArr.timestamp + "]  <a  data-toggle='modal' data-target='#setcard' class='user chatUser level" + messageArr.level + "'>" + messageArr.username + "</a>: <span style='color:" + messageArr.colorCode + "'>" + messageArr.message + "</span><br/>");
                        } else {
                            $(currentChatTab).append("[" + messageArr.timestamp + "]  <a  data-toggle='modal' data-target='#setcard' class='user chatUser level" + messageArr.level + "'>" + messageArr.username + "</a>: " + messageArr.message + "<br/>");
                        }
                    });
                    
                    // Scroll bottom 
                    $(".contentChat").each(function(key,value) {
                        var bottomHeight = $(".contentChat")[key].scrollHeight;
                        $(this).scrollTop(bottomHeight);
                    });
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

                    // Check, if user not found
                    if (data.message) {
                        $('.setcard_name').html(data.message);
                        $('.setcard_born').html('');
                        $('.setcard_bio').html('');
                        $('.setcard_picture').html('<img class="setcartd_picture_src img-circle" src="' + window.location.href + 'profilePic/default.png"/>');
                        return;
                    }

                    // Realname
                    if (!!data.realName) {
                        $('.setcard_name').html(data.realName + ' alias "' + userClick.html() + '"');
                    } else {
                        $('.setcard_name').html(userClick.html());
                    }

                    // Birthdate
                    if (data.birthdate != '0000-00-00') {
                        $('.setcard_born').html('Born in: ' + data.birthdate);
                    }

                    // Bio
                    if (!!data.bio) {
                        $('.setcard_bio').html(data.bio);
                    }

                    // Avatar
                    if (!!data.avatar) {
                        $('.setcard_picture').html('<img class="setcartd_picture_src img-circle" src="avatar/?user=' + userClick.html() + '"/>');
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

    // Helpcenter
    $('.bottomBar').click(function() {
        var height = $('.bottomBar').css('height');
        if (height === "24px") {
            // Expand
            $('.bottomBar').animate({height: 240}, 600);
        } else {
            // Small Version
            $('.bottomBar').animate({height: 24}, 600);
        }
    });

    // Hide helpcenter
    $('.hideHelpcenter').click(function() {
        $('.bottomBar').fadeOut();
    })
    // ...
});
