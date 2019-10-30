<?php

namespace Desymfony\DesymfonyBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class UsuarioType extends AbstractType{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'symfony_symfonybundle_usuariotype';

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'text',array('attr' => array('placeholder' => 'Entre su nombre')))
            ->add('apellidos')
            ->add('direccion', 'textarea')
            ->add('telefono')
            ->add('dni', 'text', array('label'=>'DNI'))
            ->add('email', 'email')
            ->add('password', 'repeated',
                array('type' => 'password',
                    'first_name'=>'password',
                    'second_name'=>'repetir_password',
                    'invalid_message' => 'Las dos contraseñas deben coincidir'
                     )
                 )
            ->add('Guardar', 'submit')
            ->add('Resetear', 'reset');
    }

}
