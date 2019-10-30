<?php

namespace Curso\CursoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction(/*$name=null*/)
    {
        $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('CursoBundle:Curso')->findAll();
        $aleatorios = array_rand($cursos,3);

        return $this->render('CursoBundle:Default:index.html.twig', array('cursos' => $cursos,'keys' => $aleatorios));
    }
    public function staticAction($nombre)
    {
        return $this->render('CursoBundle:Static:'.$nombre.'.html.twig');
    }
    public function loginAction(Request $peticion, $error=null)
    {
        $autherror = $peticion->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        if( isset($autherror ) && $autherror->getMessage() == 'Bad credentials.')
            $autherror = 'Nombre de usuario o contrase&nacute;a incorrectos.';

        return $this->render( 'CursoBundle:Default:login.html.twig',
            array( 'last_username' => $peticion->getSession()->get(SecurityContext::LAST_USERNAME),
                    'error' => $autherror,
                    'notification' => $error,
            ));
//        return $this->render('CursoBundle:Default:login.html.twig');
    }
    public function adminAction()
    {
        return $this->render('CursoBundle:Admin:index.html.twig', array('usuario' => $user = $this->getUser()));
    }

    /**
     * Lists all Curso entities.
     *
     */
    public function listAction($error=null)
    {
        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('CursoBundle:Curso')->findAll();
        $entities = $em->getRepository('CursoBundle:Curso')->masRecientes();

        return $this->render('CursoBundle:Curso:list.html.twig', array(
            'cursos' => $entities,
            'error' => $error
        ));
    }


    /**
     * Finds and displays a Profesor entity.
     *
     */
    public function getProfesorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CursoBundle:Profesor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profesor entity.');
        }

        return $this->render('CursoBundle:Profesor:data.html.twig', array(
            'profesor' => $entity,
        ));
    }

    /**
     * Finds and displays a Curso entity.
     *
     */
    public function getCursoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        return $this->render('CursoBundle:Curso:data.html.twig', array(
            'curso' => $entity,
        ));
    }



}
