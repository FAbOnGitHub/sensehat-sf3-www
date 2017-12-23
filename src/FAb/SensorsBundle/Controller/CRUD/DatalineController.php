<?php

namespace FAb\SensorsBundle\Controller;

use FAb\SensorsBundle\Entity\Dataline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Dataline controller.
 *
 * @Route("crud/dataline")
 */
class DatalineController extends Controller
{
    /**
     * Lists all dataline entities.
     *
     * @Route("/", name="crud_dataline_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();

        return $this->render('dataline/index.html.twig', array(
            'datalines' => $datalines,
        ));
    }

    /**
     * Creates a new dataline entity.
     *
     * @Route("/new", name="crud_dataline_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dataline = new Dataline();
        $form = $this->createForm('FAb\SensorsBundle\Form\DatalineType', $dataline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataline);
            $em->flush();

            return $this->redirectToRoute('crud_dataline_show', array('id' => $dataline->getId()));
        }

        return $this->render('dataline/new.html.twig', array(
            'dataline' => $dataline,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dataline entity.
     *
     * @Route("/{id}", name="crud_dataline_show")
     * @Method("GET")
     */
    public function showAction(Dataline $dataline)
    {
        $deleteForm = $this->createDeleteForm($dataline);

        return $this->render('dataline/show.html.twig', array(
            'dataline' => $dataline,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dataline entity.
     *
     * @Route("/{id}/edit", name="crud_dataline_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dataline $dataline)
    {
        $deleteForm = $this->createDeleteForm($dataline);
        $editForm = $this->createForm('FAb\SensorsBundle\Form\DatalineType', $dataline);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crud_dataline_edit', array('id' => $dataline->getId()));
        }

        return $this->render('dataline/edit.html.twig', array(
            'dataline' => $dataline,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dataline entity.
     *
     * @Route("/{id}", name="crud_dataline_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dataline $dataline)
    {
        $form = $this->createDeleteForm($dataline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dataline);
            $em->flush();
        }

        return $this->redirectToRoute('crud_dataline_index');
    }

    /**
     * Creates a form to delete a dataline entity.
     *
     * @param Dataline $dataline The dataline entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dataline $dataline)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crud_dataline_delete', array('id' => $dataline->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
