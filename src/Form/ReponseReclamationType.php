<?php

namespace App\Form;

use App\Entity\ReponseReclamation;
use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ReponseReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description' , textareatype::class, [
                'attr' => [
                    'placeholder' => "description",
                    'class' => 'form-control',
                ],
            ] );
        $builder->add('reclamation',EntityType::class,['class'=>Reclamation::class,'choice_label'=>'titre',
            'attr'=> [
                'placeholder'=> "reclamation titre",
                'class'=> 'form-control',
            ]
        ])        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseReclamation::class,
        ]);
    }
}
