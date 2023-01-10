<?php

namespace App\Form;

use App\Entity\Projects;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProjectsType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', 'Titre du projet'))
            ->add('date', DateType::class, $this->getConfiguration('Date de réalisation', "date"))
            ->add('category', TextType::class, $this->getConfiguration('Catégorie', "Catégorie du projet"))
            ->add('description', TextType::class, $this->getConfiguration('Description', "Description du projet"))
            ->add('cover', FileType::class, $this->getConfiguration('Couverture', "fichier"))
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
