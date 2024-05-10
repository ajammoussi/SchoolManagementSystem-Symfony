<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name:',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'background-color: #33353d; color: #eceeef;',
                    'required' => true,
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'background-color: #33353d; color: #eceeef;',
                    'required' => true,
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message:',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'style' => 'background-color: #33353d; color: #eceeef;',
                    'required' => true,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }
}