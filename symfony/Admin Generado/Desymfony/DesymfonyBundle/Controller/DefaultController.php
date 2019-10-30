<?php

namespace Desymfony\DesymfonyBundle\Controller;

use Desymfony\DesymfonyBundle\Entity\Ponencia;
use Desymfony\DesymfonyBundle\Entity\Ponente;
use Desymfony\DesymfonyBundle\Entity\Usuario;
use Desymfony\DesymfonyBundle\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DesymfonyBundle:Default:index.html.twig', array('name' => $name));
    }

    public function contactoAction()
    {
        return $this->render ('DesymfonyBundle:Default:contacto.html.twig');
    }

    function pruebaBDAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponentes = $em->getRepository('DesymfonyBundle:Ponente')
            ->findAll();

        return $this->render('DesymfonyBundle:Default:ponentes.html.twig',
            array('ponentes' => $ponentes)
        );
    }



    function estaticaAction($nombre)
    {
        return $this->render('DesymfonyBundle:Estaticas:'.$nombre.'.html.twig');
    }


    public function ponentesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponentes = $em->getRepository('DesymfonyBundle:Ponente')
            ->findAll();

        return $this->render('DesymfonyBundle:Default:ponentes.html.twig',
            array('ponentes' => $ponentes)
        );
    }

    function registroAction(Request $peticion)
    {
        $usuario = new Usuario();
        $usuario->setEmail("@gmail.com");
        $formulario = $this->createForm(new UsuarioType(), $usuario);

        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info',
                '¡Felicidades! Te has registrado correctamente en Desymfony');

            return $this->redirect($this->generateUrl('ponentes'));
        }

        return $this->render(
            'DesymfonyBundle:Usuario:registro.html.twig',
            array('formulario' => $formulario->createView())
        );

    }


    public function portadaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponencias = $em->getRepository('DesymfonyBundle:Ponencia')
            ->findAll();
        return $this->render('DesymfonyBundle:Default:portada.html.twig',
            array('usuario' => $user = $this->getUser(), 'ponencias' => $ponencias));

    }

}
