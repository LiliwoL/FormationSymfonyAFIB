<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('age')
            ->add('image')
            ->add('biography')
            // On doit spécifier à quoi doit ressemble ce champ
            // https://symfony.com/doc/current/reference/forms/types/entity.html
            ->add('movies', EntityType::class, [
                // looks for choices from this entity
                'class' => Movie::class,

                // uses the Movie.title property as the visible option string
                'choice_label' => 'title',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false, //https://symfony.com/doc/current/reference/forms/types/form.html#by-reference
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actor::class,
        ]);
    }
}
