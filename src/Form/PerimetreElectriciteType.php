<?php

namespace App\Form;

use App\Entity\PerimetreElectricite;
use App\Entity\Segmentation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PerimetreElectriciteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFourniture',DateType::class, ['widget' => 'single_text','label'=>'Date de début de fourniture '])
            ->add('PDL', TextType::class,['label'=>'PDL:'])
            ->add('nomPtLivraison', TextType::class,['label'=>'Nom du point de livraison:'])
            ->add('seg', ChoiceType::class,[
                'label'=>'Segmentation',
                'choices'=>[
                    ''=>'',
                    'C1'=>'C1',
                    'C2'=>'C2',
                    'C3'=>'C3',
                    'C4'=>'C4',
                ]
            ])
            ->add('segmentation', EntityType::class,[
                'class'=> Segmentation::class,
                'placeholder'=>'',
                'query_builder'=> function (EntityRepository $er) {
                    return $er->createQueryBuilder('s');
                },
                'label'=> 'FTA'
            ])
            ->add('pte', NumberType::class,['label'=>'Pte:'])
            ->add('HPH', NumberType::class,['label'=>'HPH:'])
            ->add('HCH', NumberType::class,['label'=>'HCH:'])
            ->add('HPE', NumberType::class,['label'=>'HPE:'])
            ->add('HCE', NumberType::class,['label'=>'HCE:'])
            ->add('psHPH', NumberType::class,[
                'label'=>'HPH'
            ])
            ->add('psHCH', NumberType::class,[
                'label'=>'HCH'
            ])
            ->add('psHPE', NumberType::class,[
                'label'=>'HPE'
            ])
            ->add('psHCE', NumberType::class,[
                'label'=>'HCE'
            ])
            ->add('psPte', NumberType::class,[
                'label'=>'Pte'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PerimetreElectricite::class,
        ]);
    }
}
