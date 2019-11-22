<?php

namespace App\Form;

use App\Entity\Mail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender', 
                EmailType::class,
                array(
                    'required' => true,
                    'label'  => 'Expéditeur: ',

                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Saissisez une adresse email valide'
                    )
                )
            )
            ->add('dest')
            ->add('object')
            ->add('body')

            /*
             * Ici on spécifie l'url d'action du formulaire
             */
            ->setAction('mail')
            /*
             * Ici on spécifie la méthode du formulaire
             */
            ->setMethod('POST')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mail::class,
        ]);
    }
}
