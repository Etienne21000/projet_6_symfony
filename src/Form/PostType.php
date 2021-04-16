<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', textType::class, ['label' => 'Titre'])
            ->add('content', textAreaType::class, ['label' => 'Description'])
            ->add('status', choiceType:: class, [
                'label' => 'Status de publication',
                'choices' => [
                    'Choisissez un status' => [
                        'Status de l\'article' => null,
                        'Publier' => 1,
                        'Brouillon' => 0
                    ],
                ],
            ])
            ->add('user_id', hiddenType::class)
            ->add('image_id', integerType::class)
            ->add('Category', choiceType::class, [
                'choices' => [
                    'Grabs' => 'grabs',
                    'Rotations' => 'rotations',
                    'Flips' => 'flips',
                    'Rotations desaxées' => 'rotations_desaxees',
                    'Slides' => 'slides',
                    'One foot tricks' => 'one_foot',
                    'Old school' => 'old'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'add_class' => Post::class,
        ]);
    }
}