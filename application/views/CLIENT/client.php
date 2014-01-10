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
                        <label>{$nickname}</label><br/>
                        {/foreach}
                        <br/><br/>
                        <a style="cursor:pointer;" data-toggle="modal" data-target="#join">Join</a> | <a href="/user/logout/" class="clientLogout">Logout</a>
                    </div>

                    <div class="contentChat">
                        {foreach name=name item=logLine from=$item.log}
                        [{$logLine.timestamp}] {$logLine.username}: {$logLine.message}<br/>
                        {/foreach}                        
                    </div>
                </div>
            </div>
            {/foreach}
            <div class="input">
                <input type="message" class="form-control message" id="message" placeholder="Message..">
            </div>
        </div>
    </div>
</div>

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