<?php

namespace Curso\CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Curso\CursoBundle\Entity\Usuario;
use Curso\CursoBundle\Form\AdminUsuarioType;

/**
 * Usuario controller.
 *
 */
class AdminUsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

//        $entities = $em->getRepository('CursoBundle:Usuario')->findAll();
        $entities = $em->getRepository('CursoBundle:Usuario')->listaAlfabeticamente();

        return $this->render('CursoBundle:AdminUsuario:index.html.twig', array(
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
//            $cursos = $form['curso_cursobundle_usuario[cursos][]']->getData();
            $cursosid = $form['cursos']->getData();

//            //adicionar los curso seleccionados.
            foreach($cursosid as $cid)
            {
                $course = $em->getRepository('CursoBundle:Curso')->find($cid);
                $course->addUsuario($entity);
                $em->persist($course);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('admin_usuario_show', array('id' => $entity->getId())));
        }

        return $this->render('CursoBundle:AdminUsuario:new.html.twig', array(
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
        $form = $this->createForm(new AdminUsuarioType(), $entity, array(
            'action' => $this->generateUrl('admin_usuario_create'),
            'method' => 'POST',
        ));

        $form->add('Insertar', 'submit', array('attr' => array('class' => 'btn btn-sm btn-warning')));
//        $form->add('submit', 'submit', array('label' => 'Create'));

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

        return $this->render('CursoBundle:AdminUsuario:new.html.twig', array(
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

        return $this->render('CursoBundle:AdminUsuario:show.html.twig', array(
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

        return $this->render('CursoBundle:AdminUsuario:edit.html.twig', array(
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
        $form = $this->createForm(new AdminUsuarioType(), $entity, array(
            'action' => $this->generateUrl('admin_usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('Update', 'submit', array('attr' => array('class' => 'btn btn-xs btn-success')));
//        $form->add('submit', 'submit', array('label' => 'Update'));

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
            $em->persist($entity);

            //curso_cursobundle_usuario[cursos][]
//            $cursos = $editForm['curso_cursobundle_usuario[cursos][]']->getData();
            $cursosid = $editForm['cursos']->getData();

//            //adicionar los curso seleccionados.
            foreach($cursosid as $cid)
            {
                $course = $em->getRepository('CursoBundle:Curso')->find($cid);
                $course->addUsuario($entity);
                $em->persist($course);
            }

//            $em->merge($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_usuario_edit', array('id' => $id)));
        }

        return $this->render('CursoBundle:AdminUsuario:edit.html.twig', array(
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

        return $this->redirect($this->generateUrl('admin_usuario'));
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
//            ->setAttribute('class','pos-right')
            ->setAction($this->generateUrl('admin_usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('Delete', 'submit', array('attr' => array('class' => 'btn btn-xs btn-danger')))
//            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
