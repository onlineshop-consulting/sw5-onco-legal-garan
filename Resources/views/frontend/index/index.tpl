{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_header_javascript_jquery_lib"}
    {$smarty.block.parent}

    {block name="onco_legal_garan_custom_selector_script"}
        {if $oncoLegalGaran.config.customSelector}
            <script type="text/html" id="onco-legal-garan-custom-tpl">
                <div class="onco-legal-garan--custom-container">
                    {include file="plugin/onco_legal_garan/notice.tpl"}
                </div>
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var tpl = document.getElementById('onco-legal-garan-custom-tpl');
                    if (!tpl) return;

                    var html = tpl.innerHTML;
                    var method = '{$oncoLegalGaran.config.customSelectorPosition|default:'append'|escape:"javascript"}';
                    var targets = document.querySelectorAll('{$oncoLegalGaran.config.customSelector|escape:"javascript"}');

                    for (var i = 0; i < targets.length; i++) {
                        if (method === 'prepend') {
                            targets[i].insertAdjacentHTML('afterbegin', html);
                        } else if (method === 'before') {
                            targets[i].insertAdjacentHTML('beforebegin', html);
                        } else if (method === 'after') {
                            targets[i].insertAdjacentHTML('afterend', html);
                        } else {
                            targets[i].insertAdjacentHTML('beforeend', html);
                        }
                    }
                });
            </script>
        {/if}
    {/block}
{/block}
