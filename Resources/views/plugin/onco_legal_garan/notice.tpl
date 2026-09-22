<div class="onco-legal-garan--notice">
    <p>
        <a href="{$oncoLegalGaran.yourEuropeUrl}"
           class="onco-legal-garan--link"
           data-onco-legal-garan="true"
           data-modal-title="{s name="ModalTitle" namespace="frontend/plugins/onco_legal_garan"}Gesetzliche Gewährleistung{/s}"
           target="_blank"
           rel="nofollow noopener">
            {s name="LinkText" namespace="frontend/plugins/onco_legal_garan"}Ihre gesetzlichen Gewährleistungsrechte{/s}
        </a>
    </p>

    <div class="onco-legal-garan--modal-template is--hidden">
        <div class="onco-legal-garan--modal-content">
            <img class="onco-legal-garan--notice-image"
                 src="{link file=$oncoLegalGaran.noticeImage}"
                 alt="{s name="NoticeAlt" namespace="frontend/plugins/onco_legal_garan"}Harmonisierter EU-Hinweis auf die gesetzliche Gewährleistung{/s}" />
            <p class="onco-legal-garan--portal-link">
                {s name="PortalLinkIntro" namespace="frontend/plugins/onco_legal_garan"}Weitere Informationen:{/s}
                <a href="{$oncoLegalGaran.yourEuropeUrl}" target="_blank" rel="nofollow noopener">{$oncoLegalGaran.yourEuropeLabel}</a>
            </p>
        </div>
    </div>
</div>
