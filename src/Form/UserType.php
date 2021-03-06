<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('username');
 if (in_array('registration', $options['validation_groups'])) {
     $builder
         ->add('plainPassword', RepeatedType::class, array(
             'type' => PasswordType::class,
             'first_options'  => array('label' => false, 'attr' => ['class' =>'input100']),
             'second_options' => array('label' => false, 'attr' => ['class' =>'input100']),
         ))
     ;
 } else {
     $builder
         ->add('plainPassword', RepeatedType::class, array(
             'required' => false,
             'type' => PasswordType::class,
             'first_options'  => array('label' => false, 'attr' => ['class' =>'input100']),
             'second_options' => array('label' => false, 'attr' => ['class' =>'input100']),
         ))
     ;
 }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
