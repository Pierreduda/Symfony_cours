<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Abonne;
use App\Entity\Emprunt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_emprunt', DateType::class, [
                "widget" => "single_text",
                "label" => "Emprunté le : "
            ])
            ->add('date_retour', DateType::class, [
                "widget" => "single_text",
                "label" => "Retourné le : ",
                "required" => false
            ])
            ->add('livre', EntityType::class, [
                "class" => Livre::class, 
                "choice_label" => function(Livre $livre){
                    return $livre->getTitre() . " - " . $livre->getAuteur();
                },
                "placeholder" => "Choisir un livre..."
            ])
            ->add('abonne', EntityType::class, [
                "class" => Abonne::class,
                "choice_label" => "pseudo",
                "label" => "Abonné",
                "placeholder" => "Choisir un abonné..."
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
