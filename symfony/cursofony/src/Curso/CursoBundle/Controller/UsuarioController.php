<?php

namespace Curso\CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Curso\CursoBundle\Entity\Usuario;
use Curso\CursoBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CursoBundle:Usuario')->findAll();

        return $this->render('CursoBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $passwordCodificado = $encoder->encodePassword( $entity->getPassword(), false );
            $entity->setPassword($passwordCodificado);

            $em->persist($entity);

            //curso_cursobundle_usuario[cursos][]
            $cursosid = $form['cursos']->getData();

//            //adicionar los curso seleccionados.
            foreach($cursosid as $cid)
            {
                $course = $em->getRepository('CursoBundle:Curso')->find($cid);
                $course->addUsuario($entity);
                $em->persist($course);
            }
            $em->flush();
            $error = 'El usuario se ha registrado correctamente! Por favor autent&iacute;quese.';

//            return $this->redirect($this->generateUrl('perfil', array('error' => $error) ));
            return $this->forward('CursoBundle:Default:login', array('error' => $error));

//            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
        }

        return $this->render('CursoBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
            'method' => 'POST',
        ));

//        $form->add('submit', 'submit', array('label' => 'Create'));
        $form->add('Registrar', 'submit', array('attr' => array('class' => 'btn btn-success')))
             ->add('Resetear', 'reset', array('attr' => array('class' => 'btn btn-danger')));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('CursoBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CursoBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CursoBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

//        $form->add('submit', 'submit', array('label' => 'Update'));
        $form->add('Guardar', 'submit', array('attr' => array('class' => 'btn btn-success')));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CursoBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $clear_list = $entity->getCursos();

        //limpiar primero para no duplicar en db y de error.
        foreach($clear_list as $curso)
        {
            $curso->removeUsuario($entity);
            $em->persist($curso);
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $passwordCodificado = $encoder->encodePassword( $entity->getPassword(), false );
            $entity->setPassword($passwordCodificado);

//            $em->merge($entity);
            $em->persist($entity);

            //curso_cursobundle_usuario[cursos][]
            $cursosid = $editForm['cursos']->getData();

//            //adicionar los curso seleccionados.
            foreach($cursosid as $cid)
            {
                $course = $em->getRepository('CursoBundle:Curso')->find($cid);
                $course->addUsuario($entity);
                $em->persist($course);
            }
            $em->flush();

            $notification = 'Cambios guardados correctamente!';

            return $this->forward('CursoBundle:Usuario:perfil', array('notification' => $notification));
//            return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
        }

        return $this->render('CursoBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CursoBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuario'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function perfilAction($notification=null)
    {
        return $this->render('CursoBundle:Usuario:perfil.html.twig', array(
                'usuario' => $user = $this->getUser(),
                'notification' => $notification
        ));
    }

    public function inscripcionAction($userid, $cursoid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CursoBundle:Usuario')->find($userid);
        $curso = $em->getRepository('CursoBundle:Curso')->find($cursoid);
        $find = false;

        foreach($curso->getUsuarios() as $us)
        {
            if($user === $us)
            {
                $find = true;break;
            }

        }
//        if(!array_search($user,$curso->getUsuarios()->toArray(),false ))
        if(! $find)
        {
//        $user->addCurso($curso);
            $curso->addUsuario($user);
//        $em->persist($user);
            $em->persist($curso);
            $em->flush();

//            $this->get('session')->getFlashBag()->add('info', 'El usuario se ha inscrito correctamente!');
            $error = 'El usuario se ha inscrito correctamente!';
        }
        else
            $error = 'El usuario ya est&aacute; inscrito en ese Curso.';

//        return $this->redirect($this->generateUrl('curso_list',array('error' => $error)));
//        return $this->listAction('El usuario se ha inscrito correctamente!');
        return $this->forward('CursoBundle:Default:list', array('error' => $error));
    }


}
