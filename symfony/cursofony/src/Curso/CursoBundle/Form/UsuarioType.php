<?php

namespace Curso\CursoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
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
            ->add('dni','text',array('label'=>'DNI'))
            ->add('direccion')
            ->add('telefono', 'text', array('invalid_message'=>'El valor introducido es incorrecto.'))
            ->add('email', 'email', array('invalid_message'=>'El email introducido es incorrecto.'))
//            ->add('password')
            ->add('password','repeated',
                array('type'=>'password',
                    'first_name'=>'Password',
                    'second_name'=>'Confirmacion',
                    'invalid_message'=>'El password y la confirmacion no coincide.'))
            ->add('cursos')
//            ->add('Registrar', 'submit', array('attr' => array('class' => 'btn btn-success')))
//            ->add('Resetear', 'reset', array('attr' => array('class' => 'btn btn-danger')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Curso\CursoBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'curso_cursobundle_usuario';
    }
}
