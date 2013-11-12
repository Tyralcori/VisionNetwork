<div class="client">
    <div class="naviChoose">
        <ul class="nav nav-tabs">
            {assign var=zaehler value=0}
            {foreach name=name item=item from=$userSession.currentChannels}
            <li {if $zaehler == 0}class="active"{/if}>
                <a href="#{$item.name}" data-toggle="tab">{$item.name}</a>
            </li>
            {assign var=zaehler value=$zaehler+1}
            {/foreach}
        </ul>
    </div>
    <div class="bodyChat">
        <div class="tab-content">
            {foreach name=name item=item from=$userSession.currentChannels}
            <div class="tab-pane active" id="{$item.name}">
                <div class="topic">{$item.topic}</div>
                <div class="bottomChannel">
                    <div class="nickList">
                        {foreach name=name item=nickname from=$item.nicks}
                        <label>{$nickname}</label><br/>
                        {/foreach}
                    </div>

                    <div class="contentChat">
                        {foreach name=name item=logLine from=$item.log}
                        [{$logLine.timestamp}] {$logLine.username}: {$logLine.message}<br/>
                        {/foreach}
                        <div class="input">
                            <input type="message" class="form-control" id="message" placeholder="Message..">
                        </div>
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
    </div>
</div>