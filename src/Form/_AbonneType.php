<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class _AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                "label" => "Pseudo",
                "help" => "180 caractères max",
                "constraints" => [
                    new Length([
                        "max" => 180,
                        "maxMessage" => "Le pseudo doit comporter 180 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le pseudo doit comporter au moins 2 caractères"
                    ]),
                    new NotBlank([
                        "message" => "Le pseudo ne peut pas être vide"
                    ])
                ]
            ])
            // ->add('roles')
            ->add('password', PasswordType::class, [
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le mot de passe doit comporter 50 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le mot de passe doit comporter au moins 2 caractères"
                    ]),
                    new NotBlank([
                        "message" => "Le mot de passe ne peut pas être vide"
                    ])
                ]
            ])

            ->add('nom', TextType::class, [
                "label" => "Nom",
                "help" => "30 caractères max",
                "constraints" => [
                    new Length([
                        "max" => 30,
                        "maxMessage" => "Le nom doit comporter 30 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le nom doit comporter au moins 2 caractères"
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                "label" => "Prenom",
                "help" => "30 caractères max",
                "constraints" => [
                    new Length([
                        "max" => 30,
                        "maxMessage" => "Le prénom doit comporter 30 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le prénom doit comporter au moins 2 caractères"
                    ])
                ]
            ])
            ->add('enregistrer', SubmitType::class, [
                "attr" => ["class" => "btn-success"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
