<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Projects;
use App\Entity\Technics;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label'=> 'category',
                'label'=>"Choisissez la catégorie correspondante:"
            ])
            ->add('description', TextType::class, $this->getConfiguration('Description', "Description du projet"))
            ->add('cover', FileType::class, $this->getConfiguration('Couverture', "fichier"))
            ->add('technics', EntityType::class,[
                'class' => Technics::class,
                'choice_label'=> 'technic',
                'label'=>"Choisissez la technique correspondante:",
                // 'multiple' => true,
                // 'expanded' => true,
            ])
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
