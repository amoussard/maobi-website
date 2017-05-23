<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Marketing\Contact;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

class EmailManager
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;
    /**
     * @var TwigEngine
     */
    protected $twigEngine;
    /**
     * @var RequestStack
     */
    protected $requestStack;
    /**
     * @var string
     */
    protected $generalEmailAddress;
    /**
     * @var string
     */
    protected $adminEmailAddress;
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $twigEngine, RequestStack $requestStack,
                                string $generalEmailAddress, string $adminEmailAddress, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->twigEngine = $twigEngine;
        $this->requestStack = $requestStack;
        $this->generalEmailAddress = $generalEmailAddress;
        $this->adminEmailAddress = $adminEmailAddress;
        $this->translator = $translator;
    }

    public function sendDebugEmail(array $debugData)
    {
        $message = $this->createAdminMessage()
            ->setSubject('Une erreur est survenue');

        $this->render(
            $message,
            'emails/admin.html.twig',
            'emails/admin.txt.twig',
            [ 'data' => $debugData ]
        );

        return $this->send($message);
    }

    public function sendContactEmail(array $contactData)
    {
        $message = $this->createToCompanyMessage()
            ->setSubject('Message from: ' . $contactData['firstName'] . ' ' . $contactData['lastName']);

        $this->render(
            $message,
            'emails/contact.html.twig',
            'emails/contact.txt.twig',
            [ 'data' => $contactData ]
        );

        return $this->send($message);
    }

    protected function send($message)
    {
        try {
            $recipients = $this->mailer->send($message);

            if ($recipients > 0) {
                return true;
            }
        } catch(\Exception $e) {
        }

        return false;
    }

    protected function createAdminMessage()
    {
        return $this->createGenericMessage()
            ->setTo($this->adminEmailAddress);
    }

    protected function createToCompanyMessage()
    {
        return $this->createGenericMessage()
            ->setTo($this->generalEmailAddress);
    }

    protected function createToSomeoneMessage(string $emailAddress)
    {
        return $this->createGenericMessage()
            ->setTo($emailAddress);
    }

    protected function createGenericMessage()
    {
        $locale = $this->requestStack->getMasterRequest()->getLocale();
        $teamName = 'The Moabi Studio\'s Team';

        if ($locale === 'fr') {
            $teamName = 'L\'équipe de Moabi Studio';
        }

        return \Swift_Message::newInstance()
            ->setFrom($this->generalEmailAddress, $teamName);
    }

    protected function render(&$message, string $htmlTemplateName, string $txtTemplateName, array $parameters)
    {
        /** @var \Swift_Message $message */
        $message
            ->setBody(
                $this->twigEngine->render(
                    $htmlTemplateName,
                    $parameters
                ),
                'text/html'
            )
            ->addPart(
                $this->twigEngine->render(
                    $txtTemplateName,
                    $parameters
                ),
                'text/plain'
            )
        ;
    }
}
