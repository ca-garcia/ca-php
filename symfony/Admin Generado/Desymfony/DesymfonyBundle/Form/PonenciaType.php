<?php

namespace Desymfony\DesymfonyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PonenciaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('slug')
            ->add('descripcion')
            ->add('fecha')
            ->add('hora')
            ->add('duracion')
            ->add('idioma')
            ->add('ponente')
            ->add('usuarios')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Desymfony\DesymfonyBundle\Entity\Ponencia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'desymfony_desymfonybundle_ponencia';
    }
}
