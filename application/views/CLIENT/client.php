<div class="client">
    <div class="topic">{$channel.join.topic}</div>
    <div class="bottomChannel">
        <div class="nickList">
            {foreach name=name item=item from=$channel.join.nicks}
            <label>{$item}</label><br/>
            {/foreach}
        </div>
        
        <div class="contentChat">
            {foreach name=name item=item from=$channel.join.log}
            <label>[{$item.timestamp}] {$item.username} : {$item.message}</label><br/>
            {/foreach}
        </div>
    </div>
</div>