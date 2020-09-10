<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JourFerie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Jourferie controller.
 *
 * @Route("jourferie")
 */
class JourFerieController extends Controller {

    /**
     *     
     * @Route("/nombredejour", name="nombredejour")
     * @Method("POST")
     */
    public function nombreDeJour() {

        $nombreDeJour = null;
        $dateDebut = 0;
        $dateFin = 0;

        if (isset($_POST['DateDebut']) && isset($_POST['DateFin'])) {
            $em = $this->getDoctrine()->getManager();

            $dateDebut = $_POST['DateDebut'];
            $dateFin = $_POST['DateFin'];

            $nombreDeJour = $em->getRepository('AppBundle:JourFerie')->nbrJoursFeries($dateDebut, $dateFin);
        }

        return $this->render('jourferie/nombreDeJour.html.twig'
                        , array('nombredejour' => $nombreDeJour,
                            'datedebut' => $dateDebut,
                            'datefin' => $dateFin,
                            )
        );
    }

    /**
     * Lists all jourFerie entities.
     *
     * @Route("/", name="jourferie_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $jourFeries = $em->getRepository('AppBundle:JourFerie')->findAll();

        return $this->render('jourferie/index.html.twig', array(
                    'jourFeries' => $jourFeries,
        ));
    }

    /**
     * Creates a new jourFerie entity.
     *
     * @Route("/new", name="jourferie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $jourFerie = new Jourferie();
        $form = $this->createForm('AppBundle\Form\JourFerieType', $jourFerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jourFerie);
            $em->flush();

            return $this->redirectToRoute('jourferie_show', array('id' => $jourFerie->getId()));
        }

        return $this->render('jourferie/new.html.twig', array(
                    'jourFerie' => $jourFerie,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jourFerie entity.
     *
     * @Route("/{id}", name="jourferie_show")
     * @Method("GET")
     */
    public function showAction(JourFerie $jourFerie) {
        $deleteForm = $this->createDeleteForm($jourFerie);

        return $this->render('jourferie/show.html.twig', array(
                    'jourFerie' => $jourFerie,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jourFerie entity.
     *
     * @Route("/{id}/edit", name="jourferie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, JourFerie $jourFerie) {
        $deleteForm = $this->createDeleteForm($jourFerie);
        $editForm = $this->createForm('AppBundle\Form\JourFerieType', $jourFerie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jourferie_edit', array('id' => $jourFerie->getId()));
        }

        return $this->render('jourferie/edit.html.twig', array(
                    'jourFerie' => $jourFerie,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jourFerie entity.
     *
     * @Route("/{id}", name="jourferie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, JourFerie $jourFerie) {
        $form = $this->createDeleteForm($jourFerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jourFerie);
            $em->flush();
        }

        return $this->redirectToRoute('jourferie_index');
    }

    /**
     * Creates a form to delete a jourFerie entity.
     *
     * @param JourFerie $jourFerie The jourFerie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(JourFerie $jourFerie) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('jourferie_delete', array('id' => $jourFerie->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
