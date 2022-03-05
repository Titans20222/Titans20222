<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numc')
            ->add('datecommande',DateType::class,['label' => 'Date Commande:   : ','widget' => 'single_text'])
            ->add('adresselivraison')
            ->add('ville')
   /*         ->add('prix_total',TextType::class, array(
        'label' => 'Total TTC :'))
            ->add('user',EntityType::class,array('class' => Users::class,'choice_label' => 'id' ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
