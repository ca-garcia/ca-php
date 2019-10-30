<?php

namespace Desymfony\DesymfonyBundle\Controller;


use Desymfony\DesymfonyBundle\Entity\Usuario;
use Desymfony\DesymfonyBundle\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class UsuarioController extends Controller{

    function registroAction(Request $peticion)
    {
        $usuario = new Usuario();
        $usuario->setEmail("@gmail.com");
        $formulario = $this->createForm(new UsuarioType(), $usuario);


        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            $encoder = $this->get('security.encoder_factory')
                ->getEncoder($usuario);
            $passwordCodificado = $encoder->encodePassword( $usuario->getPassword(), false );
            $usuario->setPassword($passwordCodificado);


            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->forward('DesymfonyBundle:Usuario:notificar',
                array(
                    'nombre' => $usuario->getNombre(),
                    'email' => $usuario->getEmail()
                )
            );

        }

        return $this->render(
            'DesymfonyBundle:Usuario:registro.html.twig',
            array('formulario' => $formulario->createView())
        );

    }


    public function notificarAction($nombre, $email)
    {
        return $this->render( 'DesymfonyBundle:Usuario:notificacion.html.twig', array( 'nombre' => $nombre, 'email' => $email) );
    }

    public function loginAction(Request $peticion)
    {
        return $this->render( 'DesymfonyBundle:Usuario:login.html.twig',
            array( 'last_username' => $peticion->getSession()->get(SecurityContext::LAST_USERNAME),
                'error' => $peticion->getSession()->get(SecurityContext::AUTHENTICATION_ERROR))
        );
    }

    public function perfilAction()
    {
        return $this->render('DesymfonyBundle:Usuario:perfil.html.twig', array('usuario' => $user = $this->getUser()));
    }


}
