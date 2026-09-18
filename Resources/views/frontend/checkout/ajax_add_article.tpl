{extends file="parent:frontend/checkout/ajax_add_article.tpl"}

{block name='checkout_ajax_add_actions'}
    {block name="onco_legal_garan_ajax_add_article_notice"}
        {if $oncoLegalGaran.show && $oncoLegalGaran.config.showOnCart}
            {include file="plugin/onco_legal_garan/notice.tpl"}
        {/if}
    {/block}
    {$smarty.block.parent}
{/block}
