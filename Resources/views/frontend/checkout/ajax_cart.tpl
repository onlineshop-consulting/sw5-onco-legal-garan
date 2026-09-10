{extends file="parent:frontend/checkout/ajax_cart.tpl"}

{block name='frontend_checkout_ajax_cart_button_container'}
    {block name="onco_legal_garan_ajax_cart_notice"}
        {if $oncoLegalGaran.config.showOnCart}
            {include file="plugin/onco_legal_garan/notice.tpl"}
        {/if}
    {/block}
    {$smarty.block.parent}
{/block}
