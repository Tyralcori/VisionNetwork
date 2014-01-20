{include "TEMPLATE/header.php"}
    {if !empty($outerLink)}
        {include "CONTENT/outer.php"}
    {else}
        {include "CONTENT/$page.php"}
    {/if}
    
    {include "ELEMENTS/bottomBar.php"}
{include "TEMPLATE/footer.php"}