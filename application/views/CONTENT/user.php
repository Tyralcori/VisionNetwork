{if $subpage eq 'norender'}
    {include "ELEMENTS/login.php"}
{elseif $subpage}
    {include "ELEMENTS/$subpage.php"}
{/if}