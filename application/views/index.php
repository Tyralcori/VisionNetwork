{include "TEMPLATE/header.php"}
    {if !empty($outerLink)}
        {include "CONTENT/outer.php"}
    {else}
        {include "CONTENT/$page.php"}
    {/if}
{include "TEMPLATE/footer.php"}