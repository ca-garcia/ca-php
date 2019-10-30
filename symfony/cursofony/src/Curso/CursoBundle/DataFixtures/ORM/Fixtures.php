<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 22/11/15
 */

namespace Curso\CursoBundle\Entity\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Curso\CursoBundle\Entity\Curso,
    Curso\CursoBundle\Entity\Profesor,
    Curso\CursoBundle\Entity\Usuario;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

//use Symfony\Component\Validator\Constraints\DateTime;


class Fixtures extends AbstractFixture implements ContainerAwareInterface
{
    private $contenedor;

    public function load(ObjectManager $manager)
    {
        //generando usuarios
        $nombres = array ("Pedro", "Juan", "Jorge", "Arturo","Carlos", "Alejandro");
        $cantNombres = 6;
        $apellidos = array ("Pérez", "García", "Díaz", "Hernández", "Martínez", "González");
        $cantApellidos = 6;


        for ($i = 0; $i < 25; $i++) {

            //nombre y apellidos aleatorios.
            $indiceNombre = rand(0,$cantNombres-1);
            $indiceApellido1 = rand(0,$cantApellidos-1);
            $indiceApellido2 = rand(0,$cantApellidos-1);
            $name = $nombres[$indiceNombre];
            $lastname = $apellidos[$indiceApellido1]." ".$apellidos[$indiceApellido2];

            $usuario = new Usuario();
            $usuario->setNombre($name);
//            $usuario->setNombre("Pepe_$i");
            $usuario->setApellidos($lastname);
//            $usuario->setApellidos("Perez");
            $usuario->setDni(strval(mt_rand(600101,991231).mt_rand(11111,99999)));//dni aleatorio.
            $usuario->setDireccion("Calle 23 y M");
            $usuario->setTelefono("535".(string)mt_rand(2600000,8000000));//telef aleatorio.
            $usuario->setEmail(strtolower($name).$i."@gmail.com");
            $usuario->setPassword("prueba");

            $encoder = $this->contenedor->get('security.encoder_factory')->getEncoder($usuario);
            $passwordCodificado = $encoder->encodePassword( $usuario->getPassword(), false );
            $usuario->setPassword($passwordCodificado);

            $manager->persist($usuario);
        }

        $manager->flush();


        //generando profesores

        $profesores = array(

            "JuanGonzalez" => array(
                "nombre" => "Juan",
                "apellidos" => "Gonzalez",
                "titulo" => "Master en Ciencias",
                "biografia" => "Natural de La Habana. Profesor de la Universidad de La Habana.",
                "telefono" => "5378333333",
                "email" => "juanHab@gmail.com",
//                "linkedin" => "http://www.linkedin.com/in/juanHab",
//                "twitter" => "http://www.twitter.com/juanHab"
            ),
            "PedroPerez" => array(
                "nombre" => "Pedro",
                "apellidos" => "Perez",
                "titulo" => "Ing. Informatico",
                "biografia" => "Natural de Cienfuegos. Graduado de la Universidad de UCLV.",
                "telefono" => "5323569874",
                "email" => "pedroCF@gmail.com",
//                "linkedin" => "http://www.linkedin.com/in/pedroCF",
//                "twitter" => "http://www.twitter.com/pedroCF"
            ),
            "JavierEguiluz" => array(
                "nombre" => "Javier",
                "apellidos" => "Eguiluz",
                "titulo" => "Master en Ciencias",
                "biografia" => "Natural de España. Cofundador y desarrollador de Symfony.",
                "telefono" => "3473353567",
                "email" => "javierE@gmail.com",
//                "linkedin" => "http://www.linkedin.com/in/javierE",
//                "twitter" => "http://www.twitter.com/javierE"
            ),
            "FabienPotencier" => array(
                "nombre" => "Fabien",
                "apellidos" => "Potencier",
                "titulo" => "CEO Symfony",
                "biografia" => "Natural de España. Fundador y desarrollador lider de Symfony.",
                "telefono" => "3412345678",
                "email" => "fabienP@gmail.com",
//                "linkedin" => "http://www.linkedin.com/in/fabienP",
//                "twitter" => "http://www.twitter.com/fabienP"
            )
        );

        foreach ($profesores as $ref => $info) {
            $prof = new Profesor();
            foreach ($info as $atributo => $valor) {
                $prof->{"set".ucfirst($atributo)}($valor);
            }

            $this->addReference($ref, $prof);
            $manager->persist($prof);
        }

        $manager->flush();

        //generando Cursos


        $curso = new Curso();
        $curso->setNombre("PHP Avanzado Framework Symfony");
        $curso->setDescripcion("Explicación de los elementos fundamentales de Symfony2. Instalacion, configuracion y puesta en marcha con un proyecto ejemplo.");
        $curso->setFechai(new \DateTime("2015-11-9"));
        $curso->setFechaf(new \DateTime("2015-11-27"));
        $curso->setHora(new \DateTime("13:00:00"));
        $curso->setDireccion("Calle 1ra y 22 #2202");
        $curso->setProfesor($manager->merge($this->getReference("FabienPotencier")));
        $manager->persist($curso);

        $curso = new Curso();
        $curso->setNombre("Web Services");
        $curso->setDescripcion("Explicación de los elementos fundamentales de un Servicio Web. Creacion y desarrollo de un proyecto ejemplo.");
        $curso->setFechai(new \DateTime("2015-12-7"));
        $curso->setFechaf(new \DateTime("2015-12-11"));
        $curso->setHora(new \DateTime("9:00:00"));
        $curso->setDireccion("Calle 1ra y 22 #2202");
        $curso->setProfesor($manager->merge($this->getReference("JuanGonzalez")));
        $manager->persist($curso);

        $curso = new Curso();
        $curso->setNombre("Java: Primeros pasos");
        $curso->setDescripcion("Explicación de los elementos fundamentales de Java. Creacion y desarrollo de un proyecto ejemplo.");
        $curso->setFechai(new \DateTime("2015-12-14"));
        $curso->setFechaf(new \DateTime("2013-12-25"));
        $curso->setHora(new \DateTime("9:00:00"));
        $curso->setDireccion("Calle 1ra y 22 #2202");
        $curso->setProfesor($manager->merge($this->getReference("PedroPerez")));
        $manager->persist($curso);

        $curso = new Curso();
        $curso->setNombre("La seguridad en Symfony2");
        $curso->setDescripcion("Explicación de los principales componentes de seguridad en Symfony2. Estudio de un caso ejemplo.");
        $curso->setFechai(new \DateTime("2015-11-9"));
        $curso->setFechaf(new \DateTime("2015-11-13"));
        $curso->setHora(new \DateTime("13:00:00"));
        $curso->setDireccion("Calle 1ra y 22 #2202");
        $curso->setProfesor($manager->merge($this->getReference("JavierEguiluz")));
        $manager->persist($curso);

        $curso = new Curso();
        $curso->setNombre("Android: Curso basico");
        $curso->setDescripcion("Explicación de los principales componentes del SDK de Android. Creacion  y estudio de un proyecto ejemlo.");
        $curso->setFechai(new \DateTime("2015-11-16"));
        $curso->setFechaf(new \DateTime("2015-11-20"));
        $curso->setHora(new \DateTime("9:00:00"));
        $curso->setDireccion("Calle 1ra y 22 #2202");
        $curso->setProfesor($manager->merge($this->getReference("PedroPerez")));
        $manager->persist($curso);

        $curso = new Curso();
        $curso->setNombre("C# Avanzado");
        $curso->setDescripcion("Curso avanzado de C# .NET utilizando Visual Studio. Introduccion de buenas practicas de POO.");
        $curso->setFechai(new \DateTime("2015-11-16"));
        $curso->setFechaf(new \DateTime("2015-11-20"));
        $curso->setHora(new \DateTime("9:00:00"));
        $curso->setDireccion("Calle 1ra y 22 #2202");
        $curso->setProfesor($manager->merge($this->getReference("JuanGonzalez")));
        $manager->persist($curso);

        $manager->flush();

        // generando usuario_curso

        $usuarios = $manager->getRepository('CursoBundle:Usuario')->findAll();

        $curso1 = $manager->getRepository('CursoBundle:Curso')->findOneBy( array( 'fechai' => new \DateTime('2015-11-16')));
        $curso2 = $manager->getRepository('CursoBundle:Curso')->findOneBy( array( 'fechai' => new \DateTime('2015-12-07')));

        $i=0;
        foreach ($usuarios as $user) {
            if ($i%3==0) {
                $curso1->addUsuario($user);
                $curso2->addUsuario($user);
            }
            elseif($i%3<1){ //para que existan Cursos sin usuarios registrados.
//            else {
                $curso2->addUsuario($user);
            }
            $i++;
        }


        $manager->persist($curso1);
        $manager->persist($curso2);

        $manager->flush();

//        //generando admin
//
//        $admin = new Administrador();
//        $admin->setNombre("Carlos A");
//        $admin->setApellidos("Secret");
//        $admin->setDni("00000000000");
//        $admin->setEmail("ca@gmail.com");
//        $admin->setPassword("123456");
//
//        $encoder = $this->contenedor->get('security.encoder_factory')->getEncoder($admin);
//        $passwordCodificado = $encoder->encodePassword( $admin->getPassword(), false );
//        $admin->setPassword($passwordCodificado);
//
//        $manager->persist($admin);
//        $manager->flush();

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
        // TODO: Implement setContainer() method.
        $this->contenedor = $container;
    }
}