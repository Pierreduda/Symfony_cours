<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum 6 caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                        'minMessage' => 'Votre mot de passe doit contenir au maximum 50 caractères.',
                    // ]),
                    // new Regex([
                    //     "pattern" => "/^(?=.{6,10}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/",
                    //     "message" => "Le mot de passe doit comporter entre 6 et 10 caractères, une minuscule, une majuscule, un chiffre, un caractère spécial"
                    ])
                ],
            ])
            ->add('prenom', TextType::class, [
                "required" => false,
                "label" => "Prénom",
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le prénom doit comporter 50 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le prénom doit comporter au moins 6 aractères"
                    ]),
                    new NotBlank([
                        "message" => "Le prénom ne peut pas être vide"
                    ])
                ]
            ])
            ->add('nom', TextType::class, [
                "required" => false,
                "label" => "Nom",
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le nom doit comporter 50 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le nom doit comporter au moins 6 aractères"
                    ]),
                    new NotBlank([
                        "message" => "Le nom ne peut pas être vide"
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
