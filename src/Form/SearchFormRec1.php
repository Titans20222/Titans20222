<?php

namespace App\Form;

use App\Data\SearchDataRec1;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Evenement;

class SearchFormRec1 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('y',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Chercher evenement'
                ]
            ])
            ->add('evenement', EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=>Evenement::class,
                'expanded'=>true,
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>SearchDataRec1::class,
            'method'=>'GET',
            'csrf_protection'=>false
        ])
        ;
    }

    public function getBlockPrefix()
    {
        return '';
    }
}