<?php

namespace Innonic\JobBundle\Controller;

use Innonic\JobBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class UserController extends Controller
{
    /**
     *
     * @param Request $request
     * @return array
     *
     * @Route("/register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Innonic\JobBundle\Form\UserType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles('ROLE_USER');
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('innonic_job_user_login');
        }

        return $this->render('JobBundle:User:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @return Response
     * @Route("/login")
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('JobBundle:User:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }

    /**
     *
     * @Route("/login_check")
     */
    public function loginCheckAction()
    {
    }
}
