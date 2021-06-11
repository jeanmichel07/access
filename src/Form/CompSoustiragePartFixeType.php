<?php

namespace App\Form;

use App\Entity\CompSoustiragePartFixe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompSoustiragePartFixeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pte')
            ->add('hph')
            ->add('hch')
            ->add('hpe')
            ->add('hce')
            ->add('segmentation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompSoustiragePartFixe::class,
        ]);
    }
}
