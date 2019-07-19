<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            //J ajoute DateType sur le champ et l option 'widget' a single_text
            //pour avoir un calandrier a la place des boutons
            //de selection.
            ->add('birthdate', DateType::class,
                [
                    'widget' => 'single_text'
                ])
            //J ajoute DateType sur le champ et l option 'widget' a single_text
            //pour avoir un calandrier a la place des boutons
            //de selection.
            ->add('deathdate', DateType::class,
                [
                    'widget' => 'single_text',
                    'required'=> false
                ])
            ->add('bio')
            ->add('enregister', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
