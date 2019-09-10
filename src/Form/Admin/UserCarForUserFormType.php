<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 02.04.2018
 * Time: 15:09
 */

namespace App\Form\Admin;


use App\Entity\Admin\Car;
use App\Entity\Admin\UserCar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCarForUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year_emb', UserCarFormType::class)
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'placeholder' => 'Choose car model.',
                'label' => 'Model',
                'choice_label' => "model"
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