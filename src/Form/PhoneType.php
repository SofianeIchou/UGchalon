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
use Symfony\Component\Validator\Constraints\Regex;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('number', TextType::class, [
            'label' => 'Numéro de téléphone',
            'help' => 'Le numéro de téléphone doit correspondre aux formats suivants : 0612345678, 06 12 34 56 78, 06.12.34.56.78, 06-12-34-56-78',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner un numéro de téléphone.',
                ]),
                new Regex([
                    'pattern' => '/^(\d{2}[ \-\.\ ]?){4}\d{2}$/',
                    'message' => 'Le numéro de téléphone doit correspondre aux formats suivants : 0612345678, 06 12 34 56 78, 06.12.34.56.78, 06-12-34-56-78',
                ])
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
