{extends file="parent:frontend/checkout/cart.tpl"}

{block name="frontend_checkout_footer"}
    {block name="onco_legal_garan_cart_notice"}
        {if $oncoLegalGaran.show && $oncoLegalGaran.config.showOnCart}
            {include file="plugin/onco_legal_garan/notice.tpl"}
        {/if}
    {/block}
    {$smarty.block.parent}
{/block}
