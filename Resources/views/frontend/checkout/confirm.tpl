{extends file="parent:frontend/checkout/confirm.tpl"}

{block name='frontend_checkout_confirm_tos_revocation_notice'}
    {$smarty.block.parent}

    {block name='onco_legal_garan_confirm_notice'}
        {if $oncoLegalGaran.config.showOnConfirm}
            {include file="plugin/onco_legal_garan/notice.tpl"}
        {/if}
    {/block}
{/block}
