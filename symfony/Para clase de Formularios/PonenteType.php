<?php

namespace Desymfony\DesymfonyBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PonenteType extends AbstractType{


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'symfony_symfonybundle_ponentetype';

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
            ->add('apellidos')
            ->add('biografia', 'textarea')
            ->add('telefono')
            ->add('url', 'url')
            ->add('email', 'email')
            ->add('twitter')
            ->add('linkedin');

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Desymfony\DesymfonyBundle\Entity\Ponente'
        ));
    }

}
