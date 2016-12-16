<?php

namespace Innonic\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     *
     * @return array
     * @Route("/admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $jobs = $this->getDoctrine()->getRepository('JobBundle:Job')->findAll();
        return $this->render('JobBundle:Admin:index.html.twig', array(
            'jobs' => $jobs
        ));
    }

}
