You are banned.
{if $userSession.bannedReason}
<br/>Ban reason: {$userSession.bannedReason}
{/if}
{if $userSession.bannedUntil}
<br/>Banned until: {$userSession.bannedUntil}
{/if}