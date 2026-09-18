{extends file="parent:frontend/detail/buy.tpl"}

{block name="frontend_detail_buy"}
    {$smarty.block.parent}

    {block name="onco_legal_garan_detail_notice"}
        {if $oncoLegalGaran.show && $oncoLegalGaran.config.showOnDetail}
            {include file="plugin/onco_legal_garan/notice.tpl"}
        {/if}
    {/block}
{/block}
