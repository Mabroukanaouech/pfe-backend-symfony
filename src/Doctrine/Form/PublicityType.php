<?php

namespace App\Doctrine\Form;

use App\Doctrine\Entity\Image;
use App\Doctrine\Entity\Publicity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PublicityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('audience')
            ->add('category',CategoryType::class)
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publicity::class,
        ]);
    }
}
