<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug')
            ->add('title')
            ->add('rated', ChoiceType::class, [
                'choices' => [
                    'G - General Audiences'              => Movie::RATED_GENERAL_AUDIENCES,
                    'PG - Parental Guidance Suggested'   => Movie::RATED_PARENTAL_GUIDANCE_SUGGESTED,
                    'PG-13 - Parents Strongly Cautioned' => Movie::RATED_PARENTS_STRONGLY_CAUTIONED,
                    'R - Restricted'                     => Movie::RATED_RESTRICTED,
                    'NC-17 - Adults Only'                => Movie::RATED_ADULTS_ONLY,
                ],
            ])
            ->add('poster')
            ->add('releasedAt', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])
            ->add('genres', EntityType::class, [
                'class'        => Genre::class,
                'choice_label' => 'name',
                'multiple'     => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
