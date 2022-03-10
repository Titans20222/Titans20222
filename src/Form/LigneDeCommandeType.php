<?php

namespace App\Form;

use App\Entity\LigneDeCommande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneDeCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numcommande')
            ->add('prix')
            ->add('qte')
            ->add('ligne')
            ->add('produit')
            ->add('commande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneDeCommande::class,
        ]);
    }
}
