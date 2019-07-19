<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('genre')
            ->add('numberOfPages')
            ->add('summary')
            // j'ajoute le champs qui me permet de définir l'auteur du livre, en lui précisant que c'est un champs
            // de type entité
            ->add('author', EntityType::class, [
                // je lui spécifie l'entité à relier
                'class' => Author::class,
                // je précise dans l'entité Author quel champs me permet de sélectionner l'auteur (l'info qui s'affichera dans
                // la liste déroulante
                'choice_label' => 'lastName',
            ])
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
