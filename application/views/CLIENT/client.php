<!-- CLIENT START //-->
<div class="client">
    <div class="naviChoose">
        <ul class="nav nav-tabs">
            {assign var=zaehler value=0}
            {foreach name=name item=item from=$userSession.currentChannels}
            <li {if $zaehler == 0}class="active"{/if}>
                <a href="#{$item.name}" data-toggle="tab" class="channelTabs" id="{$zaehler}">{$item.name}</a>
            </li>
            {assign var=zaehler value=$zaehler+1}
            {/foreach}            
        </ul>
    </div>
    <div class="bodyChat">
        <div class="tab-content">
            {foreach name=name item=item from=$userSession.currentChannels}
            <div class="tab-pane active" id="{$item.name}">
                <a style="cursor:pointer;" data-toggle="modal" data-target="#topic"><div class="topic topic_{$item.name}">{$item.topic}</div></a>
                <div class="bottomChannel">
                    <div class="nickList">
                        {foreach name=name item=nickname from=$item.nicks}
                        <a data-toggle="modal" data-target="#setcard" class="user chatUser level{$nickname.level}">{$nickname.name}</a><br/>
                        {/foreach}                       
                    </div>
                    <div class="options">
                        <a style="cursor:pointer;" data-toggle="modal" data-target="#settings">Settings</a> | <a style="cursor:pointer;" data-toggle="modal" data-target="#profile">Profile</a> | <a style="cursor:pointer;" data-toggle="modal" data-target="#join">Join</a> | <a href="/user/logout/" class="clientLogout">Logout</a>
                    </div>
                    <div class="contentChat chat_{$item.name}">
                        {foreach name=name item=logLine from=$item.log}
                        [{$logLine.timestamp}] <a data-toggle="modal" data-target="#setcard" class="user chatUser level{$logLine.level}">{$logLine.username}</a>: {$logLine.message}<br/>
                        {/foreach}                        
                    </div>
                </div>
            </div>
            {/foreach}
            <div class="input messageInput">
                <input type="message" class="form-control message" id="message" placeholder="Message..">
            </div>
        </div>
    </div>
</div>
<!-- CLIENT END //-->

<!-- SETTINGS MODAL START //-->
<div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Edit settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-channel" action="/settings/edit" method="POST" role="form">
                    <label>Global settings</label>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    BLA BLA 
                                </label>
                            </div>
                        </div>
                    </div> 
                    <button type="submit" name="join" class="btn btn-default">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>           
        </div>
    </div>
</div>
<!-- SETTINGS MODAL END //-->

<!-- SETCARD MODAL START //-->
<div class="modal fade" id="setcard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">User profile</h4>
            </div>
            <div class="modal-body">
                <label class="setcard_picture"></label>
                <label class="setcard_name">Loading user..</label>
                <div class="form-group">
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label class="setcard_born"></label><br/>
                            <label class="setcard_bio"></label>
                        </div>
                    </div>
                </div> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>           
        </div>
    </div>
</div>
<!-- SETCARD MODAL END //-->

<!-- PROFILE EDIT MODAL START //-->
<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Edit profile</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-channel" enctype="multipart/form-data" action="/profile/edit" method="POST" role="form">
                    <label>Upload Avatar</label>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="file" name="avatarPicUnique" class="btn btn-success form-control" id="avatar" placeholder="Path...">
                        </div>
                    </div> 

                    <label>Bio</label>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" id="bio" class="form-control" name="Bio">
                        </div>
                    </div> 
                    <button type="submit" name="join" class="btn btn-default">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>           
        </div>
    </div>
</div>
<!-- PROFILE EDIT MODAL END //-->

<!-- JOIN MODAL START //-->
<div class="modal fade" id="join" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">New channel</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-channel" action="/channel/join" method="POST" role="form">
                    <label>Enter a channel</label>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="channel" name="channel" class="form-control" id="channelID" placeholder="Channelname..">
                        </div>
                    </div>    
                    <button type="submit" name="join" class="btn btn-default">Join</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>           
        </div>
    </div>
</div>
<!-- JOIN MODAL END //-->

<!-- TOPIC EDIT START //-->
<div class="modal fade" id="topic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Change topic</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-channel" action="/channel/changeTopic" method="POST" role="form">
                    <label>Enter a new topic</label>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" name="topicName" class="topicName form-control" id="topic" placeholder="Topic..">
                            <input type="hidden" name="channelTopic" class="hiddenChannelValue" id="hiddenChannelValue" value=""/>
                        </div>
                    </div>    
                    <button type="submit" name="changeTopic" class="changeTopic btn btn-default">Change</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>           
        </div>
    </div>
</div>
<!-- TOPIC EDIT END //-->