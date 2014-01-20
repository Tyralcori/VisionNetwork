<div id="top" class="welcomeLayer">
    <div class="center-text">
        {if {$outerLink|strstr:$smarty.server.HTTP_HOST}}
        <h1>SAFE LINK</h1>
        <h3>You can make sure, that this link is safe, but we do not own the following content.</h3>
        <h4><em>{$outerLink}</em></h4>
        <a href="{$outerLink}" class="btn btn-default btn-lg">Continue</a>
        {else}
        <h1>ATTENTION</h1>
        <h3>You are now leaving Vision Network! <br/>We do not support and owning the following site.</h3>
        <h4><em>{$outerLink}</em></h4>
        <a href="{$outerLink}" class="btn btn-default btn-lg">Continue</a>
        {/if}
    </div>
</div>
