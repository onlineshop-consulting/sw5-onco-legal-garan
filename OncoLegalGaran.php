<?php

namespace OncoLegalGaran;

use Enlight_Controller_ActionEventArgs;
use OncoLegalGaran\Services\LifeCycleService;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OncoLegalGaran extends Plugin
{
    /** @var ContainerInterface */
    protected $container;

    /** @var string[] */
    const CACHE_LIST = [
        ActivateContext::CACHE_TAG_TEMPLATE,
        ActivateContext::CACHE_TAG_CONFIG,
        ActivateContext::CACHE_TAG_PROXY,
        ActivateContext::CACHE_TAG_THEME,
        ActivateContext::CACHE_TAG_HTTP,
    ];

    /** @var array<string, string> */
    const PORTAL_PATHS = [
        'bg' => 'гаранции',
        'cs' => 'záruky_cs',
        'da' => 'garantier',
        'de' => 'garantien',
        'el' => 'εγγυήσεις',
        'en' => 'guarantees',
        'es' => 'garantías',
        'et' => 'garantiid',
        'fi' => 'virhevastuu',
        'fr' => 'garanties',
        'ga' => 'ráthaíochtaí',
        'hr' => 'jamstva_hr',
        'hu' => 'jótállás',
        'it' => 'garanzie',
        'lt' => 'garantijos',
        'lv' => 'garantijas',
        'mt' => 'garanziji',
        'nl' => 'garantie',
        'pl' => 'gwarancje',
        'pt' => 'garantias',
        'ro' => 'garanții',
        'sk' => 'záruky_sk',
        'sl' => 'jamstva_sl',
        'sv' => 'reklamationsrätt',
    ];

    /** @var string[] */
    const BUNDLED_NOTICE_LANGUAGES = [
        'bg', 'cs', 'da', 'de', 'el', 'en', 'es', 'et', 'fi', 'fr', 'ga', 'hr',
        'hu', 'it', 'lt', 'lv', 'mt', 'nl', 'pl', 'pt', 'ro', 'sk', 'sl', 'sv',
    ];

    /** @return array */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutPostDispatch',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_OncoLegalGaran' => 'onGetBackendController',
        ];
    }

    /** @return string */
    public function onGetBackendController()
    {
        return $this->getPath() . '/Controllers/Backend/OncoLegalGaran.php';
    }

    /** @return void */
    public function onCheckoutPostDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        $controller = $args->getSubject();

        if ($controller->Request()->getActionName() !== 'confirm') {
            return;
        }

        $view = $controller->View();
        $view->addTemplateDir($this->getPath() . '/Resources/views');

        $language = $this->getShopLanguage();

        $view->assign('oncoLegalGaran', [
            'noticeImage' => $this->getNoticeImage($language),
            'yourEuropeUrl' => $this->getPortalUrl($language),
            'yourEuropeLabel' => $this->getPortalLabel($language),
        ]);
    }

    /** @return void */
    public function uninstall(UninstallContext $context)
    {
        $this->getLifeCycleService()->uninstall($context->keepUserData());

        $context->scheduleClearCache(self::CACHE_LIST);

        parent::uninstall($context);
    }

    /** @return void */
    public function update(UpdateContext $context)
    {
        $context->scheduleClearCache(self::CACHE_LIST);
    }

    /** @return void */
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(self::CACHE_LIST);
    }

    /** @return void */
    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(self::CACHE_LIST);
    }

    /** @return string */
    private function getShopLanguage()
    {
        $shop = $this->container->initialized('shop')
            ? $this->container->get('shop')
            : null;

        if ($shop && $shop->getLocale()) {
            return strtolower(substr($shop->getLocale()->getLocale(), 0, 2));
        }

        return 'en';
    }

    /** @return string */
    private function getNoticeImage($language)
    {
        if (!in_array($language, self::BUNDLED_NOTICE_LANGUAGES, true)) {
            $language = 'en';
        }

        return 'frontend/_public/src/img/onco_legal_garan/legal-guarantee-notice-' . $language . '.svg';
    }

    /** @return string */
    private function getPortalUrl($language)
    {
        return 'https://europa.eu/youreurope/' . rawurlencode($this->getPortalPath($language));
    }

    /** @return string */
    private function getPortalLabel($language)
    {
        return 'europa.eu/youreurope/' . $this->getPortalPath($language);
    }

    /** @return string */
    private function getPortalPath($language)
    {
        // Local copy: dereferencing an array constant needs PHP 7.0
        $paths = self::PORTAL_PATHS;

        return isset($paths[$language]) ? $paths[$language] : $paths['en'];
    }

    /** @return LifeCycleService */
    private function getLifeCycleService()
    {
        return new LifeCycleService(
            $this->container->get('models'),
            $this->getPath()
        );
    }
}
