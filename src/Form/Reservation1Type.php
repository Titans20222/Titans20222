<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Reservation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbrplace',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            $builder->add('adresseemail',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            $builder->add('numtel',TextareaType::class,['attr' => [
                'placeholder' => "titre",
            
                'class' => 'form-control',
            ],]);
            $builder ->add('idevenement',EntityType::class, [
                'class' => Evenement::class,
                'query_builder' => function (EvenementRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'nomEvenement',
            ]
        )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
