<?php
namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', textType::class, ['label' => 'Titre'])
            ->add('content', textAreaType::class, ['label' => 'Description'])
            ->add('status', choiceType:: class, [
                'choices' => [
                    'Publier' => 1,
                    'Brouillon' => 0
                ],
                'label' => 'Statut de la publication',
            ])
            ->add('user_id', hiddenType::class)
            ->add('category', choiceType::class, [
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