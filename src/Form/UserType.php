<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

        $builder
            ->add('name', textType::class, [
                'label' => 'Pseudo',
            ])
            ->add('email', emailType::class, [
                'label' => 'Votre mail',
            ])
            ->add('validate_email', emailType::class, [
                'label' => 'Validez votre mail',
                'mapped' => false,
            ])
            ->add('pass', passwordType::class, [
                'label' => 'Votre mot de passe'
            ])
            ->add('validate_pass', passwordType::class, [
                'label' => 'Validez votre mot de passe',
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'add_class' => User::class,
        ]);
    }

}