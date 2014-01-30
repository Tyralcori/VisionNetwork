{if !empty($channel.join.state) AND $channel.join.state eq 'FULL'}
    {include "CLIENT/full.php"}
{/if}
<div class="channelChooser">
    <form class="form-horizontal form-channel" action="/channel/join" method="POST" role="form">
        <label>Enter a channel</label>
        <div class="form-group">
            <div class="col-sm-10">
                <input type="channel" name="channel" class="form-control" id="channelID" placeholder="Channelname..">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="join" class="btn btn-default">Join</button>
                <button type="button" class="btn btn-default" onClick="document.location.reload(true)">Channel overview</button>
            </div>
        </div>        
    </form>
</div>