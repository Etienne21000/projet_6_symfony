<?php
namespace App\Form;

use App\Entity\FigureRequest;
use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('figureTitle', textType::class, ['label' => 'Titre'])
            ->add('figureContent', textAreaType::class, ['label' => 'Description'])
            ->add('figureStatus', choiceType:: class, [
                'choices' => [
                    'Publier' => 1,
                    'Brouillon' => 0
                ],
                'label' => 'Statut de la publication',
            ])
            ->add('figureUserId', hiddenType::class)
            ->add('figureCategory', choiceType::class, [
                'choices' => [
                    'Grabs' => 'grabs',
                    'Rotations' => 'rotations',
                    'Flips' => 'flips',
                    'Rotations desaxées' => 'rotations_desaxees',
                    'Slides' => 'slides',
                    'One foot tricks' => 'one_foot',
                    'Old school' => 'old'
                ],
            ])
            ->add('mediaLink', hiddenType::class)
            ->add('image', FileType::class, [
                'label' => 'Importer une image',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                    ])
                ]
            ])
            ->add('mediaPostId', hiddenType::class)
            ->add('resMediaId', hiddenType::class)
            ->add('resType', choiceType::class, [
                'label' => 'Type de fichier',
                'choices' => [
                    'Image' => 1,
                    'Vidéo' => 0
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'add_class' => FigureRequest::class,
        ]);
    }
}