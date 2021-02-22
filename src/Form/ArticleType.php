<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre',
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci de renseigner un titre'
                ]),
                new Length ([
                    'min' => 1,
                    'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractère(s)',
                    'max' => 100,
                    'maxMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères',
                ]),
            ]
        ])
        ->add('content', CKEditorType::class, [
            'label' => 'Contenu',
            'purify_html' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci de renseigner un contenu'
                ]),
                new Length ([
                    'min' => 1,
                    'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractère(s)',
                    'max' => 50000,
                    'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères',
                ]),
            ]
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Publier',
            'attr' => [
                'class' => 'btn btn-yellow col-12 my-5',
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
