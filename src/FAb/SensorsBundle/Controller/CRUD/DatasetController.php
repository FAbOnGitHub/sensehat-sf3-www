<?php

namespace FAb\SensorsBundle\Controller\CRUD;

use FAb\SensorsBundle\Entity\Dataset;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dataset controller.
 *
 * @Route("crud/dataset")
 */
class DatasetController extends Controller
{
    /**
     * Lists all dataset entities.
     *
     * @Route("/", name="crud_dataset_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datasets = $em->getRepository('SensorsBundle:Dataset')->findAll();

        return $this->render('dataset/index.html.twig', array(
            'datasets' => $datasets,
        ));
    }

    /**
     * Creates a new dataset entity.
     *
     * @Route("/new", name="crud_dataset_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dataset = new Dataset();
        $form = $this->createForm('FAb\SensorsBundle\Form\DatasetType', $dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataset);
            $em->flush();

            return $this->redirectToRoute('crud_dataset_show', array('id' => $dataset->getId()));
        }

        return $this->render('dataset/new.html.twig', array(
            'dataset' => $dataset,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dataset entity.
     *
     * @Route("/{id}", name="crud_dataset_show")
     * @Method("GET")
     */
    public function showAction(Dataset $dataset)
    {
        $deleteForm = $this->createDeleteForm($dataset);

        return $this->render('dataset/show.html.twig', array(
            'dataset' => $dataset,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dataset entity.
     *
     * @Route("/{id}/edit", name="crud_dataset_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dataset $dataset)
    {
        $deleteForm = $this->createDeleteForm($dataset);
        $editForm = $this->createForm('FAb\SensorsBundle\Form\DatasetType', $dataset);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crud_dataset_edit', array('id' => $dataset->getId()));
        }

        return $this->render('dataset/edit.html.twig', array(
            'dataset' => $dataset,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dataset entity.
     *
     * @Route("/{id}", name="crud_dataset_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dataset $dataset)
    {
        $form = $this->createDeleteForm($dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dataset);
            $em->flush();
        }

        return $this->redirectToRoute('crud_dataset_index');
    }

    /**
     * Creates a form to delete a dataset entity.
     *
     * @param Dataset $dataset The dataset entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dataset $dataset)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crud_dataset_delete', array('id' => $dataset->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
