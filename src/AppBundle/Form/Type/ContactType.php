<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.label.name',
                'attr' => [
                    'placeholder' => 'form.placeholders.name'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.label.email',
                'attr' => [
                    'placeholder' => 'form.placeholders.email'
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'form.label.subject',
                'attr' => [
                    'placeholder' => 'form.placeholders.subject'
                ],
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'form.label.message',
                'attr' => [
                    'placeholder' => 'form.placeholders.message'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.label.submit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'contact'
        ]);
    }
}
