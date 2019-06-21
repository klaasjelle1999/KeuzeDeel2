<?php


namespace App\FormType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
            ])
            ->add('role', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => [
                    'Admin' => "ROLE_ADMIN",
                ],
                'label' => false,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'De wachtwoorden moeten overeenkomen.',
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
            ])
        ;
    }
}