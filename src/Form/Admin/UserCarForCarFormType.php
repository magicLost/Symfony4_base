<?php

namespace App\Form\Admin;


use App\Entity\Admin\User;
use App\Entity\Admin\UserCar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCarForCarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year_emb', UserCarFormType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'placeholder' => 'Choose owner name.',
                'label' => 'Owner name',
                'choice_label' => "name"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserCar::class
        ]);
    }
}