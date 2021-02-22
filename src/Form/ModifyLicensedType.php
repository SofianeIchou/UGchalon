<?php

namespace App\Form;

use App\Entity\Licensed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ModifyLicensedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un prénom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                        'maxMessage' => 'Le prénom doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]

            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un nom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                        'maxMessage' => 'Le nom doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('gender', ChoiceType::class, array(
                'label' => 'Genre',
                'choices' => array('Veuillez sélectionner un genre' => null, 'Homme' => 'Homme', 'Femme' => 'Femme'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un genre.',
                    ]),

                ]

            ))
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ],
                'empty_data' => '',
                'widget' => 'choice',
                'years' => range(1900, date('Y')),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une date de naissance.',
                    ]),

                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une adresse.',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'L\'adresse doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 150,
                        'maxMessage' => 'L\'adresse doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un code postal.',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le code postal doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 6,
                        'maxMessage' => 'Le code postal doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une ville.',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'La ville doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 60,
                        'maxMessage' => 'La ville doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('socialSecurityNumber', TextType::class, [
                'label' => 'Numéro de sécurité sociale',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un numéro de sécurité sociale.',
                    ]),
                    new Length([
                        'min' => 15,
                        'minMessage' => 'La numéro de sécurité doit contenir {{ limit }} caractères. (clé comprise)',
                        // max length allowed by Symfony for security reasons
                        'max' => 15,
                        'maxMessage' => 'Le numéro de sécurité sociale doit contenir {{ limit }} caractères. (clé comprise)'
                    ]),
                ]
            ])
            ->add('discipline', ChoiceType::class, array(
                'label' => 'Discipline',
                'choices'   => array('Veuillez sélectionner une discipline' => null, 'Baby Gym' => 'Baby Gym', 'Gymnastique masculine' => 'Gymnastique masculine', 'Loisir' => 'Loisir'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une discipline.',
                    ]),

                ]
            ))
            ->add('medicalRemark', TextareaType::class, [
                'label' => 'Remarque(s) médicale',
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 1000,
                        'maxMessage' => 'Le message doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('save', SubmitType::class, [ // Ajout d'un champ de type bouton de validation
                'label' => 'Sauvegarder les modifications',
                'attr' => [
                    'class' => 'btn btn-yellow col-12'
                ]    // Texte du bouton
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Licensed::class,
            //'attr' => [
                //'novalidate' => 'novalidate'
            //]
        ]);
    }
}
