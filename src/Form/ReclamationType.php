<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder    ->add('titre', textareatype::class,[
            'attr' => [
                'placeholder' => "titre",

                'class' => 'form-control',
            ],
        ] );
          $builder  ->add('description', textareatype::class,[
              'attr' => [
                  'placeholder' => "description",

                  'class' => 'form-control',
              ],          ] );
          $builder  ->add('date', textareatype::class,[
              'attr' => [
                  'placeholder' => "date",

                  'class' => 'form-control',
              ],          ] );
           $builder ->add('type',textareatype::class, [
               'attr' => [
                   'placeholder' => "type",

                   'class' => 'form-control',
               ],           ] );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }

}
