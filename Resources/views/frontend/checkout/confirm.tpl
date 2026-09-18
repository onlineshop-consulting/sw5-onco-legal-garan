{extends file="parent:frontend/checkout/confirm.tpl"}

{block name='frontend_checkout_confirm_tos_revocation_notice'}
    {$smarty.block.parent}

    {block name='onco_legal_garan_confirm_notice'}
        {if $oncoLegalGaran.show && $oncoLegalGaran.config.showOnConfirm}
            {include file="plugin/onco_legal_garan/notice.tpl"}
        {/if}
    {/block}
{/block}


{block name='frontend_checkout_confirm_confirm_table_actions'}
    {$smarty.block.parent}

    {block name='onco_legal_garan_confirm_notice_inline'}
        {if $oncoLegalGaran.show && $oncoLegalGaran.config.showInlineOnConfirm}
            <div class="onco-legal-garan--inline-confirm">
                {include file="plugin/onco_legal_garan/notice_inline.tpl"}
            </div>
        {/if}
    {/block}
{/block}
