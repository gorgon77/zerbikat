<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Udala;
use Zerbikat\BackendBundle\Form\UdalaType;

/**
 * Udala controller.
 *
 * @Route("/udala")
 */
class UdalaController extends Controller
{
    /**
     * Lists all Udala entities.
     *
     * @Route("/", name="udala_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $udalas = $em->getRepository('BackendBundle:Udala')->findAll();
            return $this->render('udala/index.html.twig', array(
                'udalas' => $udalas,
            ));
        }else if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('udala_show', array('id' => $this->getUser()->getUdala()->getId()));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Udala entity.
     *
     * @Route("/new", name="udala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN')) {
            $udala = new Udala();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\UdalaType', $udala);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($udala);
                $em->flush();

                return $this->redirectToRoute('udala_show', array('id' => $udala->getId()));
            }

            return $this->render('udala/new.html.twig', array(
                'udala' => $udala,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Finds and displays a Udala entity.
     *
     * @Route("/{id}", name="udala_show")
     * @Method("GET")
     */
    public function showAction(Udala $udala)
    {
        $deleteForm = $this->createDeleteForm($udala);

        return $this->render('udala/show.html.twig', array(
            'udala' => $udala,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Udala entity.
     *
     * @Route("/{id}/edit", name="udala_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Udala $udala)
    {
        $deleteForm = $this->createDeleteForm($udala);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\UdalaType', $udala);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($udala);
            $em->flush();

            return $this->redirectToRoute('udala_edit', array('id' => $udala->getId()));
        }

        return $this->render('udala/edit.html.twig', array(
            'udala' => $udala,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Udala entity.
     *
     * @Route("/{id}", name="udala_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Udala $udala)
    {
        $form = $this->createDeleteForm($udala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($udala);
            $em->flush();
        }

        return $this->redirectToRoute('udala_index');
    }

    /**
     * Creates a form to delete a Udala entity.
     *
     * @param Udala $udala The Udala entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Udala $udala)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('udala_delete', array('id' => $udala->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
