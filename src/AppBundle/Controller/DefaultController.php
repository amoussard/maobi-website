<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/process", name="process")
     */
    public function processAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/process.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/about.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl('contact'),
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $sent = $this->get('app.manager.emails')->sendContactEmail($data);

            if ($sent) {
                $this->addFlash(
                    'contact_success',
                    $this->get('translator')->trans('form.message.success', [], 'contact')
                );

                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/blog", name="blog")
     */
    public function blogAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/blog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
