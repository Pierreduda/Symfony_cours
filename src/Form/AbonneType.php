<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le pseudo doit comporter 50 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le pseudo doit comporter au moins 6 aractères"
                    ]),
                    new NotBlank([
                        "message" => "Le pseudo ne peut pas être vide"
                    ])
                ]
            ])
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Bibliothécaire" => "ROLE_BIBLIOTHECAIRE",
                    "Abonné" => "ROLE_ABONNE"
                ],
                "multiple" => true,
                "expanded" => false // true on peut choisir plusieurs roles, mais comme ils sont imbriqués c'est inutile
            ])
            ->add('password', TextType::class, [
                "mapped" => false, // quand mapped vaut false, l'input password ne doit pas être considéré comme une propriété de l'objet Abonne => si on remplit l'input la valeur ne sera pas affectée directement à l'objet Abonne
                "required" => false,
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le mot de passe doit comporter 50 caractères maximum",
                        "min" => 2,
                        "minMessage" => "Le mot de passe doit comporter au moins 6 aractères"
                    ]),
                    new NotBlank([
                        "message" => "Le mot de passe ne peut pas être vide"
                    // ]),
                    // new Regex([
                    //     "pattern" => "/^(?=.{6,10}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/",
                    //     "message" => "Le mot de passe doit comporter entre 6 et 10 caractères, une minuscule, une majuscule, un chiffre, un caractère spécial"
                    ])
                ]
            ]) 
            ->add('nom')
            ->add('prenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
