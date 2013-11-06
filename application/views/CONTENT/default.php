{if $userSession AND isset($userSession.email)}
    {if isset($userSession.banned) AND $userSession.banned}
        {include "ELEMENTS/banned.php"}
    {else}
        {include "ELEMENTS/overview.php"}
    {/if}
{else}
    {include "ELEMENTS/login.php"}
{/if}