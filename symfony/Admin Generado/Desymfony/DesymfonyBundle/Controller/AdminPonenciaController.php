<?php

namespace Desymfony\DesymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminPonenciaController extends Controller {
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponencias = $em->getRepository('DesymfonyBundle:Ponencia')
            ->findAll();

        return $this->render('DesymfonyBundle:AdminPonencia:list.html.twig',
            array('ponencias' => $ponencias)
        );
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ponencia = $em->find('DesymfonyBundle:Ponencia', $id);
        return $this->render('DesymfonyBundle:AdminPonencia:show.html.twig',
            array('ponencia' => $ponencia)
        );
    }

    public function editAction($id, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $ponencia = $em->find('DesymfonyBundle:Ponencia', $id);

        $formulario = $this->createFormBuilder($ponencia)
            ->add('titulo')
            ->add('descripcion', 'textarea')
            ->add('fecha', 'date')
            ->add('hora', 'time')
            ->add('duracion', 'integer')
            ->add('idioma', 'choice', array('choices' => array('es' => 'es', 'en' => 'en')))
            ->add('ponente')
            ->add('Guardar cambios', 'submit')
            ->getForm();
        $formulario->setData($ponencia);


        //$peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponencia);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_ponencia_list'));
        }

        return $this->render('DesymfonyBundle:AdminPonencia:edit.html.twig',
            array(  'ponencia' => $ponencia,
                'formulario' => $formulario->createView()
            )
        );
    }


}
