<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Author;
use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class ArtworkSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search_artwork', SearchType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3'],
                'help_attr' => ['class' => 'alert alert-danger'],
                'required' => false
            ])
            ->add('search_author', SearchType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3'],
                'help_attr' => ['class' => 'alert alert-danger'],
                'required' => false
            ])
            ->add('media', EntityType::class, [
                'class' => Media::class,
                'attr' => ['class' => 'form-select select-2'],
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3'],
                'help_attr' => ['class' => 'alert alert-danger'],
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
