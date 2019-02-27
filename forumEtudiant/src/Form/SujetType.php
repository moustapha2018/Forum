<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\Sujet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SujetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('image')
            //->add('createdAt')
            ->add('niveau',EntityType::class,[
                'class' => Niveau::class,
                'choice_label' => 'libelle'
            ])
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sujet::class,
        ]);
    }
}
