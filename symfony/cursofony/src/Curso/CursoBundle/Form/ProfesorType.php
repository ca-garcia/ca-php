<?php

namespace Curso\CursoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfesorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('titulo')
            ->add('biografia', 'textarea', array('attr' => array('style' => 'height:100px;width:250px') ))
            ->add('telefono')
            ->add('email')
            ->add('cursos')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Curso\CursoBundle\Entity\Profesor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'curso_cursobundle_profesor';
    }
}
