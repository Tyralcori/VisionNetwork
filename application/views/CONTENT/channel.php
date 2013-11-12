{if $channel.join.state eq 'FULL'}
    {include "CLIENT/full.php"}
{elseif $channel.join.state eq 'CONNECTED'}
    {include "CLIENT/client.php"}
{/if}