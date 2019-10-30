<?php
/**
 * Created by PhpStorm.
 * User: joe
 * Date: 29/08/15
 * Time: 12:10 AM
 */

namespace Desymfony\DesymfonyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Desymfony\DesymfonyBundle\Entity\Ponencia,
    Desymfony\DesymfonyBundle\Entity\Ponente,
    Desymfony\DesymfonyBundle\Entity\Usuario;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadInicial extends AbstractFixture implements ContainerAwareInterface
{
    private $contenedor;

    public function load(ObjectManager $manager)
    {
        //generando usuarios

        for ($i = 0; $i < 50; $i++) {
            $usuario = new Usuario();
            $usuario->setNombre("Pepe_$i");
            $usuario->setApellidos("Perez");
            $usuario->setDni("1111$i");
            $usuario->setDireccion("Aquí");
            $usuario->setTelefono("555555");
            $usuario->setEmail("pepe$i@gmail.com");

            $usuario->setPassword("prueba");
            $encoder = $this->contenedor->get('security.encoder_factory')
                ->getEncoder($usuario);
            $passwordCodificado = $encoder->encodePassword( $usuario->getPassword(), $usuario->getSalt() );
            $usuario->setPassword($passwordCodificado);


            $manager->persist($usuario);
        }

        $manager->flush();


        //generando ponentes

        $ponentes = array(

            "JuanGonzalez" => array(
                "nombre" => "Juan",
                "apellidos" => "Gonzalez",
                "biografia" => "Natural de La Habana",
                "telefono" => "7366466",
                "url" => "http://www.juanHab.com",
                "email" => "juanHab@gmail.com",
                "linkedin" => "http://www.linkedin.com/in/juanHab",
                "twitter" => "http://www.twitter.com/juanHab"
            ),
            "PedroPerez" => array(
                "nombre" => "Pedro",
                "apellidos" => "Perez",
                "biografia" => "Natural de Cienfuegos",
                "telefono" => "7335356",
                "url" => "http://www.pedroCF.com",
                "email" => "pedroCF@gmail.com",
                "linkedin" => "http://www.linkedin.com/in/pedroCF",
                "twitter" => "http://www.twitter.com/pedroCF"
            )
        );

        foreach ($ponentes as $ref => $info) {
            $ponente = new Ponente();
            foreach ($info as $atributo => $valor) {
                $ponente->{"set".ucfirst($atributo)}($valor);
            }

            $this->addReference($ref, $ponente);
            $manager->persist($ponente);
        }

        $manager->flush();

        //generando ponencias


        $ponencia = new Ponencia();
        $ponencia->setTitulo("Introduccion a Symfony2");
        $ponencia->setDescripcion("Explicación de los elementos fundamentales de Symfony2");
        $ponencia->setFecha(new \DateTime("2013-12-5"));
        $ponencia->setHora(new \DateTime("9:00:00"));
        $ponencia->setDuracion(45);
        $ponencia->setIdioma("es");
        $ponencia->setPonente($manager->merge($this->getReference("PedroPerez")));
        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo("El modelo de Symfony2");
        $ponencia->setDescripcion("Explicación de los elementos fundamentales del acceso a datos en Symfony2");
        $ponencia->setFecha(new \DateTime("2013-12-6"));
        $ponencia->setHora(new \DateTime("9:00:00"));
        $ponencia->setDuracion(45);
        $ponencia->setIdioma("es");
        $ponencia->setPonente($manager->merge($this->getReference("JuanGonzalez")));
        $manager->persist($ponencia);

        $manager->flush();

        // generando usuario_ponencia

        $usuarios = $manager->getRepository('DesymfonyBundle:Usuario')->findAll();

        $ponencia1 = $manager->getRepository('DesymfonyBundle:Ponencia')->findOneBy( array( 'fecha' => new \DateTime('2013-12-05')));
        $ponencia2 = $manager->getRepository('DesymfonyBundle:Ponencia')->findOneBy( array( 'fecha' => new \DateTime('2013-12-06')));

        $i=0;
        foreach ($usuarios as $user) {
            if ($i%3==0) {
                $ponencia1->addUsuario($user);
            }
            else {
                $ponencia2->addUsuario($user);
            }
            $i++;
        }


        $manager->persist($ponencia1);
        $manager->persist($ponencia2);

        $manager->flush();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->contenedor = $container;
    }
}