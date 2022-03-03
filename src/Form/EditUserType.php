<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un e-mail',
                    ]),
                ],
                'required' => true,
                'attr' => ['class' =>'form-control'],
            ])
            ->add('nom', TextType::class,['constraints' => [
                new NotBlank([
                    'message' => 'Merci d\'entrer un nom',
                ]),
            ],
            'required' => true,
            'attr' => ['class' =>'form-control'],
        ])
            ->add('prenom', TextType::class,['constraints' => [
                new NotBlank([
                    'message' => 'Merci d\'entrer un prenom',
                ]),
            ],
            'required' => true,
            'attr' => ['class' =>'form-control'],
        ])
     ->add('adresse', TextType::class,[ 'constraints' => [
        new NotBlank([
            'message' => 'Merci d\'entrer un e-mail',
        ]),
    ],
    'required' => true,
    'attr' => ['class' =>'form-control'],
])

            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Client' => 'ROLE_CLIENT',
                    'Artisan' => 'ROLE_ARTISAN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}