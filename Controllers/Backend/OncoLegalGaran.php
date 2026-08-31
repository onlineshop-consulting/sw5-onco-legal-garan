<?php

use OncoLegalGaran\Services\LifeCycleService;

class Shopware_Controllers_Backend_OncoLegalGaran extends Shopware_Controllers_Backend_ExtJs
{
    /** @return void */
    public function createAttachmentsAction()
    {
        $german = $this->isGermanBackend();

        try {
            $service = new LifeCycleService(
                $this->get('models'),
                $this->container->getParameter('onco_legal_garan.plugin_dir')
            );

            $created = $service->createAttachments();

            if ($created > 0) {
                $message = $german
                    ? sprintf('Gewährleistungs-PDF wurde für %d Shop(s) als Anhang der sORDER Mail hinterlegt.', $created)
                    : sprintf('PDF attached to the sORDER mail for %d shop(s).', $created);
            } else {
                $message = $german
                    ? 'Keine Änderungen. Alle Shops sind bereits eingerichtet.'
                    : 'No changes. All shops are already set up.';
            }

            $this->View()->assign([
                'success' => true,
                'created' => $created,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            $this->View()->assign([
                'success' => false,
                'message' => ($german ? 'Fehler: ' : 'Error: ') . $e->getMessage(),
            ]);
        }
    }

    /** @return bool */
    private function isGermanBackend()
    {
        $identity = $this->get('auth')->getIdentity();

        if ($identity && !empty($identity->locale)) {
            return strpos(strtolower($identity->locale->getLocale()), 'de') === 0;
        }

        return false;
    }
}
