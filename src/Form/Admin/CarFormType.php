<?php

namespace App\Form\Admin;


use App\Entity\Admin\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model', TextType::class, [
                'trim' => true,
                'required' => true,
                'label' => 'Car model',
                'attr' => [
                    'placeholder' => 'Model name'
                ]
            ])
            ->add('country', CountryType::class, [
                'required' => true,
                'label' => 'Country',
                'placeholder' => 'Where car model was born?'
            ])
            ->add('madeAt', DateType::class, [
                'required' => true,
                'label' => 'Born date of this model',
                'widget' => 'single_text'
            ])
            ->add('userCar', CollectionType::class, [
                'entry_type' => UserCarForCarFormType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class
        ]);
    }
}