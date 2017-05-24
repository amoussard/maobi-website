<?php

namespace AppBundle\Twig;

use AppBundle\Manager\LocaleManager;

/**
 * ImageExtension
 */
class LocaleExtension extends \Twig_Extension
{
    /**
     * @var LocaleManager
     */
    protected $localeManager;

    /**
     * @param LocaleManager $localeManager
     */
    public function __construct(LocaleManager $localeManager) {
        $this->localeManager = $localeManager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('languageName', [ $this, 'getLanguageName' ]),
            new \Twig_Function('getReverseLocaleUrl', [ $this, 'getReverseLocaleUrl' ]),
            new \Twig_Function('getTargetLocale', [ $this, 'getTargetLocale' ]),
        ];
    }

    public function getLanguageName(string $locale): string
    {
        return $this->localeManager->getLanguageName($locale);
    }

    public function getReverseLocaleUrl()
    {
        return $this->localeManager->generateReverseLocaleUrl();
    }

    public function getTargetLocale()
    {
        return $this->localeManager->getTargetLocale();
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'twig_locale';
    }
}
