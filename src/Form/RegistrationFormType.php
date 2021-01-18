<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your Firstname.'
                    ]),
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Pleaser enter your Lastname.'
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email address',
                'help' => 'A confirmation link will be send to this email address',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'PLease enter an email address.'
                    ]),
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a Password.'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => "Your password should be at least {{ limit }} characters minimum.",
                        'max' => 4096
                    ]),
                ],
                'first_options' => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm Password',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our privacy terms.',
                    ]),
                ],
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
