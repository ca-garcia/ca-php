<?php

namespace Desymfony\DesymfonyBundle\Controller;
use Desymfony\DesymfonyBundle\Entity\Ponencia;
use Desymfony\DesymfonyBundle\Form\PonenciaPonenteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PonenciaController extends Controller
{

    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponencias = $em->getRepository('DesymfonyBundle:Ponencia')
            ->findAll();

        return $this->render('DesymfonyBundle:Ponencia:ponencias.html.twig',
            array('ponencias' => $ponencias)
        );
    }

    public function apuntarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ponencia = $em->getRepository('DesymfonyBundle:Ponencia')
            ->find($id);


        $ponencia->addUsuario($this->getUser());

        $em->flush();

        return new Response("Se apuntó");

    }

    function nuevaAction(Request $peticion)
    {
        $ponencia = new Ponencia();

        $formulario = $this->createForm(new PonenciaPonenteType(), $ponencia);


        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->persist($ponencia->getPonente());
            $em->persist($ponencia);
            $em->flush();

            return $this->forward('DesymfonyBundle:Ponencia:notificar',
                array(
                    'titulo' => $ponencia->getTitulo(),
                    'ponente' => $ponencia->getPonente()->getNombre()." ".$ponencia->getPonente()->getApellidos()
                )
            );

        }

        return $this->render(
            'DesymfonyBundle:Ponencia:nuevaPonencia.html.twig',
            array('formulario' => $formulario->createView())
        );

    }

    public function notificarAction($titulo, $ponente)
    {
        return $this->render( 'DesymfonyBundle:Ponencia:notificacion.html.twig', array( 'titulo' => $titulo, 'ponente' => $ponente) );
    }

}