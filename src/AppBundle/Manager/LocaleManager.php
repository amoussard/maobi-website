<?php

namespace AppBundle\Manager;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

/**
 * ImageExtension
 */
class LocaleManager extends \Twig_Extension
{
    protected $router;
    protected $requestStack;

    public function __construct(Router $router, RequestStack $requestStack) {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function generateReverseLocaleUrl()
    {
        $targetLocale = $this->getTargetLocale();

        $currentRequest = $this->requestStack->getCurrentRequest();
        $requestAttributes = $currentRequest->attributes->all();

        $requestAttributes['_route_params']['_locale'] = $targetLocale;

        return $this->router->generate($requestAttributes['_route'], $requestAttributes['_route_params']);
    }

    public function getTargetLocale(): string
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $currentLocale = $currentRequest->getLocale();

        return $currentLocale === 'en' ? 'fr' : 'en';
    }

    public function getLanguageName(string $locale): string
    {
        return \Locale::getDisplayLanguage($locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'twig_locale';
    }
}
