<?php
namespace App\SignUpForm;

// SignUpFormType.php

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Date of Birth',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationality',
                'attr' => ['class' => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'attr' => ['class' => 'form-control']
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone Number',
                'attr' => ['class' => 'form-control']
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
            ->add('education', TextType::class, [
                'label' => 'Previous Education',
                'attr' => ['class' => 'form-control']
            ])
            ->add('program', ChoiceType::class, [
                'label' => 'Intended Program of Study',
                'choices' => [
                    'MPI' => 'mpi',
                    'CBA' => 'cba',
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('achievements', TextareaType::class, [
                'label' => 'Achievements and Awards',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
            ->add('essay', TextareaType::class, [
                'label' => 'Personal Statement',
                'attr' => ['class' => 'form-control', 'rows' => 6]
            ])
            ->add('declaration', CheckboxType::class, [
                'label' => 'I hereby declare that the information provided is accurate and complete to the best of my knowledge.',
                'mapped' => false, // This field is not mapped to any property
                'attr' => ['class' => 'form-check-input']
            ]);
    }
}

