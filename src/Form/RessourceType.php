<?php

namespace App\Form;


use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('media_id', hiddenType::class)
            ->add('type', choiceType::class, [
                'label' => 'Type de fichier',
                'choices' => [
                    'Image' => 1,
                    'Vidéo' => 0
                ],
            ])
            ->add('status', choiceType::class, [
                'label' => 'Statut du média',
                'choices' => [
                    'Publier' => 1,
                    'Brouillon' => 0
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'add_class' => Ressource::class,
        ]);
    }

}