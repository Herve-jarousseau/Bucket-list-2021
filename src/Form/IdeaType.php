<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Souhait"
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description"
            ])
            ->add('author', TextType::class, [
                "label" => "Pseudo"
            ])
            ->add('category', EntityType::class, [
                'label' => "Categories",
                'class' => "App\Entity\Category",
                'choice_label' => "name"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
