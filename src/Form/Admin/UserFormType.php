<?php

namespace App\Form\Admin;

use App\Entity\Admin\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'trim' => true,
                'required' => true,
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Enter your name, please'
                ]
            ])
            ->add('realName', TextType::class, [
                'trim' => true,
                'required' => true,
                'label' => 'Real name',
                'attr' => [
                    'placeholder' => 'Enter your real name, please'
                ]
            ])
            ->add('email', EmailType::class, [
                'trim' => true,
                'required' => true,
                'label' => "Email",
                'attr' => [
                    'placeholder' => 'Enter your email address, please'
                ]
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sex',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female'
                ],
                'placeholder' => "Who are you?"
            ])
            ->add('bornAt', DateType::class, [
                'label' => "Borm at",
                'widget' => 'single_text'
            ])
            ->add('isBan', ChoiceType::class, [
                "label" => "Is ban",
                'choices' => [
                    'Пора забанить?' => false,
                    "No" => false,
                    'Yes' => true
                ],
            ])
            ->add('userCar', CollectionType::class, [
                'entry_type' => UserCarForUserFormType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;

        //dump($builder->all());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
