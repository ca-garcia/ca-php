<?php

namespace Curso\CursoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('attr' => array('style' => 'width:250px') ))
            ->add('descripcion', 'textarea', array('attr' => array('style' => 'height:100px;width:250px') ))
            ->add('fechai', 'date', array('label'=>'Fecha inicio'))
            ->add('fechaf', 'date', array('label'=>'Fecha final'))
            ->add('hora')
            ->add('direccion')
            ->add('profesor')
            ->add('usuarios')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Curso\CursoBundle\Entity\Curso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'curso_cursobundle_curso';
    }
}
