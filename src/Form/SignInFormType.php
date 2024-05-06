<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignInFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'demo@insat.com',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password:',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'demo1234',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign in',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }
}
