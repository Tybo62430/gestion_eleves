<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Note;

/**
 * Etudiant controller.
 *
 * @Route("etudiant")
 */
class EtudiantController extends Controller {

    /**
     * Lists all etudiant entities.
     *
     * @Route("/", name="etudiant_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $etudiants = $em->getRepository('AppBundle:Etudiant')->findAll();

        return $this->render('etudiant/index.html.twig', array(
                    'etudiants' => $etudiants,
//                    'joursferies' => $joursFeries
        ));
    }

    /**
     * Creates a new etudiant entity.
     *
     * @Route("/new", name="etudiant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $etudiant = new Etudiant();
        $form = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('etudiant_show', array('id' => $etudiant->getId()));
        }

        return $this->render('etudiant/new.html.twig', array(
                    'etudiant' => $etudiant,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a etudiant entity.
     *
     * @Route("/{id}", name="etudiant_show")
     * @Method("GET")
     */
    public function showAction(Etudiant $etudiant) {
        $deleteForm = $this->createDeleteForm($etudiant);

        $notesEtudiant = $this->getDoctrine()
                ->getRepository(Note::class)
                ->findNotesByEtudiantId($etudiant->getId());


        return $this->render('etudiant/show.html.twig', array(
                    'etudiant' => $etudiant,
                    'delete_form' => $deleteForm->createView(),
                    'notesEtudiant' => $notesEtudiant
        ));
    }

    /**
     * Displays a form to edit an existing etudiant entity.
     *
     * @Route("/{id}/edit", name="etudiant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etudiant $etudiant) {
        $deleteForm = $this->createDeleteForm($etudiant);
        $editForm = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_edit', array('id' => $etudiant->getId()));
        }

        return $this->render('etudiant/edit.html.twig', array(
                    'etudiant' => $etudiant,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etudiant entity.
     *
     * @Route("/{id}", name="etudiant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etudiant $etudiant) {
        $form = $this->createDeleteForm($etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }

    /**
     * Creates a form to delete a etudiant entity.
     *
     * @param Etudiant $etudiant The etudiant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etudiant $etudiant) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('etudiant_delete', array('id' => $etudiant->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
