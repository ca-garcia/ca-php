<?php

namespace Desymfony\DesymfonyBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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

}