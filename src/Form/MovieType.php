<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('duration')
            ->add('synopsys')
            ->add('poster')
            ->add('year', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('nationality')
            // On doit spécifier à quoi doit ressemble ce champ
            // https://symfony.com/doc/current/reference/forms/types/entity.html
            ->add('actors', EntityType::class, [
                // looks for choices from this entity
                'class' => Actor::class,

                // uses the Actor.firstname property as the visible option string
                'choice_label' => 'firstname',
                    /*function ($actor)
                {
                    return $actor->getDisplayName();
                },*/

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
