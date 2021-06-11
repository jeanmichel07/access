<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Vendeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raisonSocial', TextType::class,['required'=>true])
            ->add('nomSignataire', TextType::class,['required'=>true])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('prenomSignataire', TextType::class,[
                'required'=>true,
                'label'=>'Prénom signataire'
            ])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('telephone', TextType::class,[
                'required'=>true,
                'label'=>'Téléphone'
            ])
            ->add('email', TextType::class,['required'=>true])
            ->add('vendeur', EntityType::class,[
                'class'=>Vendeur::class,
                'query_builder'=>function(EntityRepository $s){
                    return $s->createQueryBuilder('v')->orderBy('v.nom');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
