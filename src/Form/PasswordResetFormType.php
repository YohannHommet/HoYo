<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class PasswordResetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'disabled' =>true,
                'label' => 'Firstname',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Lastname',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Email address',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Current password',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'New Password',
                    'attr' => [
                        'class' => 'form-control mb-2'
                    ],
                    new Length([
                        'min' => 6,
                        'minMessage' => "Your password should be 6 characters minimum",
                        'max' => 4096,
                        'maxMessage' => 'Your password is invalid'
                    ]),
                    new NotBlank()
                ],
                'second_options' => [
                    'label' => 'Repeat new Password',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    new Length([
                        'min' => 6,
                        'minMessage' => "Your password should be 6 characters minimum",
                        'max' => 4096,
                        'maxMessage' => 'Your password is invalid'
                    ]),
                    new NotBlank()
                ]
            ])

        ;
    }


    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
