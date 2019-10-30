<?php

namespace Desymfony\DesymfonyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PonenciaPonenteType extends AbstractType
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
            ->add('descripcion', 'textarea')
            ->add('fecha', 'date')
            ->add('hora', 'time')
            ->add('duracion', 'integer')
            ->add('idioma', 'choice', array('choices' => array('es' => 'es', 'en' => 'en')))
            ->add('ponente', new PonenteType())
            ->add('usuarios')
            ->add('Guardar', 'submit')
            ->add('Resetear', 'reset');
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Desymfony\DesymfonyBundle\Entity\Ponencia',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'desymfony_desymfonybundle_ponencia_ponente';
    }
}
