<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEvenement',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            $builder  ->add('date');
            $builder  ->add('nomLieu',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            $builder  ->add('prix',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            $builder  ->add('nbrplacedispo',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            #->add('image',ImageType::class)
           # ->add('file',FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
