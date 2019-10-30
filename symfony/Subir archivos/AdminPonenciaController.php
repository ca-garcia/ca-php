<?php

namespace Desymfony\DesymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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


    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ponencia = $em->find('DesymfonyBundle:Ponencia', $id);

        $formulario = $this->createFormBuilder($ponencia)
            ->add('titulo')
            ->add('descripcion', 'textarea')
            ->add('fecha', 'date')
            ->add('hora', 'time')
            ->add('duracion', 'number')
            ->add('idioma')
			->add('ponente')
			->add('fichero')
            ->getForm();
        $formulario->setData($ponencia);


        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            $ponencia->subirArchivo();
			
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
