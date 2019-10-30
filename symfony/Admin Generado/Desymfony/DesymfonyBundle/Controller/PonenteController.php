<?php

namespace Desymfony\DesymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PonenteController extends Controller{

    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponentes = $em->getRepository('DesymfonyBundle:Ponente')
            ->findAll();

        return $this->render('DesymfonyBundle:Ponente:ponentes.html.twig',
            array('ponentes' => $ponentes)
        );
    }
}
