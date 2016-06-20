<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Etiketa;
use Zerbikat\BackendBundle\Form\EtiketaType;

/**
 * Etiketa controller.
 *
 * @Route("/etiketa")
 */
class EtiketaController extends Controller
{
    /**
     * Lists all Etiketa entities.
     *
     * @Route("/", name="etiketa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $etiketas = $em->getRepository('BackendBundle:Etiketa')->findAll();
            return $this->render('etiketa/index.html.twig', array(
                'etiketas' => $etiketas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Etiketa entity.
     *
     * @Route("/new", name="etiketa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $etiketum = new Etiketa();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\EtiketaType', $etiketum);
            $form->handleRequest($request);

            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($etiketum);
                $em->flush();

                return $this->redirectToRoute('etiketa_show', array('id' => $etiketum->getId()));
            }

            return $this->render('etiketa/new.html.twig', array(
                'etiketum' => $etiketum,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Finds and displays a Etiketa entity.
     *
     * @Route("/{id}", name="etiketa_show")
     * @Method("GET")
     */
    public function showAction(Etiketa $etiketum)
    {
        $deleteForm = $this->createDeleteForm($etiketum);

        return $this->render('etiketa/show.html.twig', array(
            'etiketum' => $etiketum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Etiketa entity.
     *
     * @Route("/{id}/edit", name="etiketa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etiketa $etiketum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($etiketum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($etiketum);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\EtiketaType', $etiketum);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($etiketum);
                $em->flush();
    
                return $this->redirectToRoute('etiketa_edit', array('id' => $etiketum->getId()));
            }
    
            return $this->render('etiketa/edit.html.twig', array(
                'etiketum' => $etiketum,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }            
    }

    /**
     * Deletes a Etiketa entity.
     *
     * @Route("/{id}", name="etiketa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etiketa $etiketum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($etiketum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($etiketum);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($etiketum);
                $em->flush();
            }
            return $this->redirectToRoute('etiketa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a form to delete a Etiketa entity.
     *
     * @param Etiketa $etiketum The Etiketa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etiketa $etiketum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etiketa_delete', array('id' => $etiketum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}