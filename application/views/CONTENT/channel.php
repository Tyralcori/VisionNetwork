{if empty($userSession.currentChannels)}
{include "ELEMENTS/overview.php"}
{else}
{include "CLIENT/client.php"}
{/if}