<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AtalaparrafoaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ordena')
            ->add('testuaeu')
            ->add('testuaes')
            ->add('createdAt', 'datetime')
            ->add('updatedAt', 'datetime')
            ->add('udala')
            ->add('atala')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Atalaparrafoa'
        ));
    }
}
