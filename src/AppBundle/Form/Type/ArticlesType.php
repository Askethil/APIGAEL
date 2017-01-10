<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lib');
        $builder->add('datecreation');
        $builder->add('stock');
        $builder->add('description');
        $builder->add('idboutique');
        $builder->add('urlimage');
        $builder->add('prix');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Articles',
            'csrf_protection' => false
        ]);
    }
}