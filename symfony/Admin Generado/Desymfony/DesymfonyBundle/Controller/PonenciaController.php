<?php

namespace Desymfony\DesymfonyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Desymfony\DesymfonyBundle\Entity\Ponencia;
use Desymfony\DesymfonyBundle\Form\PonenciaType;

/**
 * Ponencia controller.
 *
 */
class PonenciaController extends Controller
{

    /**
     * Lists all Ponencia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DesymfonyBundle:Ponencia')->findAll();

        return $this->render('DesymfonyBundle:Ponencia:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Ponencia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Ponencia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ponencia_show', array('id' => $entity->getId())));
        }

        return $this->render('DesymfonyBundle:Ponencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Ponencia entity.
     *
     * @param Ponencia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ponencia $entity)
    {
        $form = $this->createForm(new PonenciaType(), $entity, array(
            'action' => $this->generateUrl('ponencia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ponencia entity.
     *
     */
    public function newAction()
    {
        $entity = new Ponencia();
        $form   = $this->createCreateForm($entity);

        return $this->render('DesymfonyBundle:Ponencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponencia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DesymfonyBundle:Ponencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ponencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DesymfonyBundle:Ponencia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponencia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DesymfonyBundle:Ponencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ponencia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DesymfonyBundle:Ponencia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Ponencia entity.
    *
    * @param Ponencia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ponencia $entity)
    {
        $form = $this->createForm(new PonenciaType(), $entity, array(
            'action' => $this->generateUrl('ponencia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ponencia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DesymfonyBundle:Ponencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ponencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ponencia_edit', array('id' => $id)));
        }

        return $this->render('DesymfonyBundle:Ponencia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Ponencia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DesymfonyBundle:Ponencia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ponencia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ponencia'));
    }

    /**
     * Creates a form to delete a Ponencia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ponencia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
