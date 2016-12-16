<?php

namespace Innonic\JobBundle\Controller;

use Innonic\JobBundle\Entity\Information;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class InformationController extends Controller
{
    /**
     * @Route("/information")
     */
    public function IndexAction()
    {
        $informations = $this->getDoctrine()->getRepository('JobBundle:Information')->findAll();

        return $this->render('JobBundle:Information:index.html.twig', array(
            'informations' => $informations
        ));
    }

    /**
     * @param Information $information
     * @return array
     *
     * @Route("/information/show/{id}")
     * @Template()
     */
    public function showAction(Information $information)
    {
        return $this->render('JobBundle:Information:_information.html.twig', array(
            'information' => $information
        ));
    }

    /**
     * Creates a new information entity.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/admin/information/new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $info = new Information();
        $form = $this->createForm('Innonic\JobBundle\Form\InformationType', $info);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($info);
            $em->flush();
            return $this->redirectToRoute('innonic_job_admin_index', array('id' => $info->getId()));
        }
        return $this->render('JobBundle:Information:new.html.twig', array(
                'information' => $info,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing information entity.
     *
     * @param Request $request
     * @param Information    $information
     *
     * @return array
     *
     * @Route("/admin/information/edit/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Information $information)
    {
        $editForm = $this->createForm('Innonic\JobBundle\Form\InformationType', $information);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information);
            $em->flush();
            return $this->redirectToRoute('innonic_job_information_edit', array('id' => $information->getId()));
        }
        return $this->render('JobBundle:Information:edit.html.twig', array(
                'information' => $information,
                'edit_form' => $editForm->createView(),
            )
        );
    }

}
