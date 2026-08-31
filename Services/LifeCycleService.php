<?php

namespace OncoLegalGaran\Services;

use DateTime;
use OncoLegalGaran\OncoLegalGaran;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Mail\Attachment;
use Shopware\Models\Mail\Mail;
use Shopware\Models\Media\Album;
use Shopware\Models\Media\Media;
use Shopware\Models\Shop\Shop;
use Symfony\Component\HttpFoundation\File\File;

class LifeCycleService
{
    const MAIL_NAME = 'sORDER';

    const MEDIA_DESCRIPTION = 'OncoLegalGaran EU legal guarantee notice';

    /** @var array<string, string> */
    const NOTICE_FILENAMES = [
        'bg' => 'Zakonova garantsiya',
        'cs' => 'Zakonna zaruka',
        'da' => 'Lovbestemt garanti',
        'de' => 'Gesetzliche Gewaehrleistung',
        'el' => 'Nomimi engyisi',
        'en' => 'Legal guarantee',
        'es' => 'Garantia legal',
        'et' => 'Seadusjargne garantii',
        'fi' => 'Lakisaateinen virhevastuu',
        'fr' => 'Garantie legale',
        'ga' => 'Rathaiocht dhlithiuil',
        'hr' => 'Zakonsko jamstvo',
        'hu' => 'Torvenyes szavatossag',
        'it' => 'Garanzia legale',
        'lt' => 'Teisine garantija',
        'lv' => 'Likumiska garantija',
        'mt' => 'Garanzija legali',
        'nl' => 'Wettelijke garantie',
        'pl' => 'Gwarancja ustawowa',
        'pt' => 'Garantia legal',
        'ro' => 'Garantia legala',
        'sk' => 'Zakonna zaruka',
        'sl' => 'Zakonsko jamstvo',
        'sv' => 'Lagstadgad reklamationsratt',
    ];

    /** @var ModelManager */
    private $modelManager;

    /** @var string */
    private $pluginPath;

    public function __construct(ModelManager $modelManager, $pluginPath)
    {
        $this->modelManager = $modelManager;
        $this->pluginPath = $pluginPath;
    }

    /** @return int */
    public function createAttachments()
    {
        /** @var Mail|null $mail */
        $mail = $this->modelManager->getRepository(Mail::class)->findOneBy(['name' => self::MAIL_NAME]);
        if (!$mail instanceof Mail) {
            return 0;
        }

        $created = 0;
        $mediaByLanguage = [];

        /** @var Shop[] $shops */
        $shops = $this->modelManager->getRepository(Shop::class)->findAll();

        foreach ($shops as $shop) {
            if ($this->attachmentExists($mail, $shop)) {
                continue;
            }

            $language = $this->getShopLanguage($shop);

            if (!isset($mediaByLanguage[$language])) {
                $media = $this->createNoticeMedia($language);
                if (!$media instanceof Media) {
                    continue;
                }
                $mediaByLanguage[$language] = $media;
            }

            $this->modelManager->persist(new Attachment($mail, $mediaByLanguage[$language], $shop));
            ++$created;
        }

        $this->modelManager->flush();

        return $created;
    }

    /** @return void */
    public function uninstall($keepUserData)
    {
        if ($keepUserData) {
            return;
        }

        $attachments = $this->modelManager->createQueryBuilder()
            ->select('attachment')
            ->from(Attachment::class, 'attachment')
            ->innerJoin('attachment.media', 'media')
            ->where('media.description = :description')
            ->setParameter('description', self::MEDIA_DESCRIPTION)
            ->getQuery()
            ->getResult();

        foreach ($attachments as $attachment) {
            $this->modelManager->remove($attachment);
        }
        $this->modelManager->flush();

        $medias = $this->modelManager->getRepository(Media::class)
            ->findBy(['description' => self::MEDIA_DESCRIPTION]);

        foreach ($medias as $media) {
            $this->modelManager->remove($media);
        }
        $this->modelManager->flush();
    }

    /** @return string */
    private function getShopLanguage(Shop $shop)
    {
        $language = 'en';

        if ($shop->getLocale()) {
            $language = strtolower(substr($shop->getLocale()->getLocale(), 0, 2));
        }

        if (!in_array($language, OncoLegalGaran::BUNDLED_NOTICE_LANGUAGES, true)) {
            $language = 'en';
        }

        return $language;
    }

    /** @return bool */
    private function attachmentExists(Mail $mail, Shop $shop)
    {
        $count = $this->modelManager->createQueryBuilder()
            ->select('COUNT(attachment.id)')
            ->from(Attachment::class, 'attachment')
            ->innerJoin('attachment.media', 'media')
            ->where('attachment.mail = :mail')
            ->andWhere('attachment.shop = :shop')
            ->andWhere('media.description = :description')
            ->setParameter('mail', $mail)
            ->setParameter('shop', $shop)
            ->setParameter('description', self::MEDIA_DESCRIPTION)
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $count > 0;
    }

    /** @return Media|null */
    private function createNoticeMedia($language)
    {
        $source = $this->pluginPath . '/Resources/pdf/legal-guarantee-notice-' . $language . '.pdf';
        if (!is_file($source)) {
            return null;
        }

        /** @var Album|null $album */
        $album = $this->modelManager->find(Album::class, Album::ALBUM_FILES);
        if (!$album instanceof Album) {
            return null;
        }

        // Local copy: dereferencing an array constant needs PHP 7.0
        $filenames = self::NOTICE_FILENAMES;
        $filename = isset($filenames[$language]) ? $filenames[$language] : $filenames['en'];

        $tempDir = sys_get_temp_dir() . '/onco-legal-garan-' . uniqid('', true);
        $tempFile = $tempDir . '/' . $filename . '.pdf';
        if (!mkdir($tempDir) || !copy($source, $tempFile)) {
            return null;
        }

        $media = new Media();
        $media->setAlbum($album);
        $media->setFile(new File($tempFile));
        $media->setDescription(self::MEDIA_DESCRIPTION);
        $media->setCreated(new DateTime());
        $media->setUserId(0);

        $this->modelManager->persist($media);
        $this->modelManager->flush($media);

        if (is_file($tempFile)) {
            unlink($tempFile);
        }
        if (is_dir($tempDir)) {
            rmdir($tempDir);
        }

        return $media;
    }
}
