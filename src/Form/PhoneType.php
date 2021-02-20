<?php

namespace App\Form;

use App\Entity\Phone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('number', TextType::class, [
            'label' => 'Numéro de téléphone',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner un numéro de téléphone.',
                ]),
                new Length([
                    'min' => 10,
                    'minMessage' => 'Le numéro de téléphone doit contenir au moins {{ limit }} caractères.',
                    // max length allowed by Symfony for security reasons
                    'max' => 20,
                    'maxMessage' => 'Le numéro de téléphone doit contenir au maximum {{ limit }} caractères.'
                ]),
            ]

        ])
        ->add('save', SubmitType::class, [
            'label' => 'Sauvegarder mon numéro de téléphone',
            'attr' => [
                'class' => 'btn btn-yellow col-12'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Phone::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
