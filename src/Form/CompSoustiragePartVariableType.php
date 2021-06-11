<?php

namespace App\Form;

use App\Entity\CompSoustiragePartVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompSoustiragePartVariableType extends AbstractType
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
            'data_class' => CompSoustiragePartVariable::class,
        ]);
    }
}
