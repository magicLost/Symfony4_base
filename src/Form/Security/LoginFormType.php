<?php

namespace App\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => "Name",
                'attr' => [
                    'placeholder' => 'Enter your name, please'
                ]
            ])
            ->add('_password', PasswordType::class, [
                'required' => true,
                'trim' => true,
                'label' => "Password",
                'attr' => [
                    'placeholder' => 'Enter your password, please'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            "csrf_protection" => true,
            "csrf_field_name" => "_csrf_token",
            'csrf_token_id' => "authenticate"
        ]);
    }
}
